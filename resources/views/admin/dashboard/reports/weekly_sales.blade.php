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
            <div class="d-flex align-items-center mt-md-0 mt-1">
              <input
                type="week"
                class="form-control shadow-none"
                name="week"
                id="week"
                value="{{ date("Y") }}-W{{ date("W") }}"
              />
            </div>
            {{-- <div class="col-12 col-md-6 mb-1 position-relative">
                <label class="form-label" for="range_week">Semana</label>
                <input type="text" id="range_week" class="form-control" value="{{ date( "Y-m-d", strtotime('this week last sunday')) }}" />
            </div> --}}
        </div>
        <div class="card-body">
            <div id="column-chart"></div>
        </div>
    </div>
</div>