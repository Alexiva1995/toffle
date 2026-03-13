<div class="col-12">
    <div class="card">
        <div class=" card-header d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-md-center align-items-start " >
            <h4 class="card-title">Informes de Ganancia por Categoría</h4>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="start_date_cat"> <i data-feather="calendar"></i> Fecha Inicio</label>
                        <input type="text" id="start_date_cat" name="start_date_cat" class="form-control flatpickr-basic" value="{{ date('Y-m-d', strtotime('-6 days')) }}" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date_cat"> <i data-feather="calendar"></i> Fecha Fin</label>
                        <input type="text" id="end_date_cat" name="end_date_cat" class="form-control flatpickr-basic" value="{{ date('Y-m-d') }}" />
                    </div>
                </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="profit_by_category_route" value="{{ route('data.chart.profit.by.category') }}">
            <div id="donut-chart-profit-by-category"></div>
        </div>
    </div>
</div>