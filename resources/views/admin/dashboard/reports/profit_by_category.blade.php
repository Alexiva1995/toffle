<div class="col-12">
    <div class="card">
        <div class=" card-header d-flex flex-md-row flex-column justify-content-md-between justify-content-start align-items-md-center align-items-start " >
            <h4 class="card-title">Informes de Ganancia por Categoría</h4>

            <div class="col-auto">
                <label class="form-label" for="week"> <i data-feather="calendar"></i> N° de Semana</label>
                <div class="d-flex align-items-center mt-md-0 mt-1"> 
                    <input type="text" id="weekCategory" name="weekCategory" data-week-category = "{{ date("Y") }}-W{{ date("W") }}" class="form-control" value="Semana {{ date("W") }}, {{ date("Y") }}"/>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="profit_by_category_route" value="{{ route('data.chart.profit.by.category') }}">
            <div id="donut-chart-profit-by-category"></div>
        </div>
    </div>
</div>