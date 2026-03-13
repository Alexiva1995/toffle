<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:process-pending {--order= : ID de orden específica para procesar} {--dry-run : Simular el proceso sin guardar cambios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza órdenes pendientes desde la 15286 y descuenta inventario de forma natural';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderIdStart = 15286;
        $specificOrderId = $this->option('order');
        $dryRun = $this->option('dry-run');

        $query = Order::whereIn('status', ['0', '1', '4']); // 0: Pendiente, 1: En Espera, 4: Otros fallos

        if ($specificOrderId) {
            $query->where('id', $specificOrderId);
        } else {
            $query->where('id', '>=', $orderIdStart);
        }

        $orders = $query->get();

        if ($orders->isEmpty()) {
            $this->info("No se encontraron órdenes pendientes para procesar.");
            return;
        }

        $this->info("Procesando {$orders->count()} órdenes...");

        foreach ($orders as $order) {
            $this->line("Procesando Orden #{$order->id} (Creada: {$order->created_at})...");

            try {
                DB::transaction(function () use ($order, $dryRun) {
                    // Lógica extraída de OrdersController::updateGeneralData para status '2' (Finalizado)
                    // 1. Descontar ingredientes con sabores (helados y otros)
                    $orderIngredients = DB::table('order_ingredient')->where('order_id', $order->id)->get();
                    
                    foreach ($orderIngredients as $ingredient) {
                        if ($ingredient->it_has_flavors == 1) {
                            if (!$ingredient->flavor_name) {
                                $this->warn("   - Salteando ingrediente ID {$ingredient->inventory_id} en Orden #{$order->id} por falta de sabor.");
                                continue;
                            }

                            $itemBase = Inventory::find($ingredient->inventory_id);
                            if (!$itemBase) continue;

                            $item = Inventory::where('product_id', $itemBase->product_id)
                                ->where('flavor_name', $ingredient->flavor_name)
                                ->first();

                            if ($item) {
                                $this->line("   - Descontando {$ingredient->portion} de '{$item->flavor_name}' (ID: {$item->id})");
                                if (!$dryRun) {
                                    $item->local -= $ingredient->portion;
                                    $item->save();
                                }
                            } else {
                                $this->error("   - No se encontró inventario para sabor '{$ingredient->flavor_name}' del producto {$itemBase->product_id}");
                            }
                        }
                    }

                    // 2. Actualizar estado de la orden
                    if (!$dryRun) {
                        // Mantenemos la fecha original desactivando timestamps automáticos temporalmente si es necesario
                        // o simplemente actualizando el status. Eloquent suele actualizar updated_at.
                        $order->status = '2'; // Finalizado
                        $order->save();
                    }
                });

                $this->info("Orden #{$order->id} procesada con éxito.");

            } catch (\Exception $e) {
                $this->error("Error procesando Orden #{$order->id}: " . $e->getMessage());
            }
        }

        if ($dryRun) {
            $this->comment("REVISIÓN FINALIZADA (MODO SIMULACIÓN)");
        } else {
            $this->info("Procesamiento completado.");
        }
    }
}
