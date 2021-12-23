<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>Historial de Pedidos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="order_history_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Plato</th>
                        <th>Mesa</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded">
                                    <div class="avatar-content">
                                        <img src="{{asset('images/icons/toolbox.svg')}}" alt="Toolbar svg" />
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-bolder">Dixons</div>
                                    <div class="font-small-2 text-muted">meguc@ruj.io</div>
                              </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light-primary me-1">
                                    <div class="avatar-content">
                                        <i data-feather="monitor" class="font-medium-3"></i>
                                    </div>
                                </div>
                                <span>Technology</span>
                            </div>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex flex-column">
                                <span class="fw-bolder mb-25">23.4k</span>
                                <span class="font-small-2 text-muted">in 24 hours</span>
                            </div>
                        </td>
                        <td>$891.2</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-bolder me-1">68%</span>
                                <i data-feather="trending-down" class="text-danger font-medium-1"></i>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->