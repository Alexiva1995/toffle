<?php

namespace App\Console\Commands;

use App\Models\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra todas las sessiones activas en el sistema';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            Log::info('Inciar Comando close:sessions ' . now()->format('Y-m-d'));
            DB::table('sessions')->delete();
            Log::info('Fin Comando close:sessions ' . now()->format('Y-m-d'));

            return Command::SUCCESS;
        } catch (\Throwable $th) {
            Log::info('error Comando close:sessions ' . now()->format('Y-m-d'));

            return Command::FAILURE;
        }
    }
}
