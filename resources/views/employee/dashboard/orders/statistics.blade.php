<!-- Statistics Card -->
<div class="card card-statistics">
    <div class="card-header">
        <h4 class="card-title">Estados de Pedidos</h4>
        <div class="d-flex align-items-center">
            {{-- <p class="card-text font-small-2 me-25 mb-0">Updated 1 month ago</p> --}}
        </div>
    </div>
    <div class="card-body statistics-body">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="d-flex flex-row">
                    <div class="avatar bg-light-warning me-2">
                        <div class="avatar-content">
                            <i data-feather="alert-circle" class="avatar-icon"></i>
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> {{ count( $orders->where('status', 0) ) }} </h4>
                        <p class="card-text font-small-3 mb-0">Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                <div class="d-flex flex-row">
                    <div class="avatar bg-light-info me-2">
                        <div class="avatar-content">
                            <i data-feather="clock" class="avatar-icon"></i>
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> {{ count( $orders->where('status', 1) )  }} </h4>
                        <p class="card-text font-small-3 mb-0">En Espera</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                <div class="d-flex flex-row">
                    <div class="avatar bg-light-success me-2">
                        <div class="avatar-content">
                            <i data-feather="check-circle" class="avatar-icon"></i>
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> {{ count( $orders->where('status', 2) )  }} </h4>
                        <p class="card-text font-small-3 mb-0">Finalizados</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="d-flex flex-row">
                    <div class="avatar bg-light-danger me-2">
                        <div class="avatar-content">
                            <i data-feather="x-circle" class="avatar-icon"></i>
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0"> {{ count( $orders->where('status', 3) )  }} </h4>
                        <p class="card-text font-small-3 mb-0">Cancelados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Statistics Card -->