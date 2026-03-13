<div class="col-12">
    <div class="card">
        <div
            class="
                card-header
                d-flex
                flex-md-row flex-column
                justify-content-md-between justify-content-start
                align-items-md-center align-items-start
            "
        >
            <h4 class="card-title">Informes de Ventas Semanales</h4>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="start_date"> <i data-feather="calendar"></i> Fecha Inicio</label>
                        <input type="text" id="start_date" name="start_date" class="form-control flatpickr-basic" value="{{ date('Y-m-d', strtotime('-6 days')) }}" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date"> <i data-feather="calendar"></i> Fecha Fin</label>
                        <input type="text" id="end_date" name="end_date" class="form-control flatpickr-basic" value="{{ date('Y-m-d') }}" />
                    </div>
                </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="weekly_sales_route" value="{{ route('data.chart.weekly.sales') }}">
            <div id="column-chart-ws"></div>
        </div>
    </div>
</div>