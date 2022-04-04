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
            <h4 class="card-title">Informes de Ganancia por Categoría</h4>
        </div>
        <div class="card-body">
            <input type="hidden" id="weekly_sales_route" value="{{ route('data.chart.weekly.sales') }}">
            <div id="donut-chart-profit-by-category"></div>
        </div>
    </div>
</div>