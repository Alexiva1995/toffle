<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>Pedidos Pendientes</h3>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="pending_order_table">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->