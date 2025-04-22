<!-- Statistics Card -->
<div class="card-statistics">
                        <h4 class="fw-bolder mb-1">Pedidos de hoy <span class="bold">  #{{ count( $orders->where('status', '2')->whereBetween ('created_at', [now()->format('Y-m-d'). " 00:00:00", now()->format('Y-m-d'). " 23:50:00"]) )  }}</span></h4>
</div>
<!--/ Statistics Card -->