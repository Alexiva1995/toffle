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
        </div>
        <div class="card-body">
            <div id="column-chart"></div>
        </div>
    </div>
</div>