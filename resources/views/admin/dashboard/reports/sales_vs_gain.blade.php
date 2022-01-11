<div class="col-12">
    <div class="card">
        <div
          class="
            card-header
            d-flex
            flex-sm-row flex-column
            justify-content-md-between
            align-items-start
            justify-content-start
          "
        >
            <div>
              <h4 class="card-title mb-25">Informes de Ventas </h4>
            </div>
            <div class="btn-group mt-md-0 mt-1" role="group" aria-label="Basic radio toggle button group">
              <input type="radio" class="btn-check" name="datetime" id="1d" autocomplete="off" checked />
              <label class="btn btn-outline-primary" for="1d">1D</label>

              <input type="radio" class="btn-check" name="datetime" id="7d" autocomplete="off" />
              <label class="btn btn-outline-primary" for="7d">7D</label>

              <input type="radio" class="btn-check" name="datetime" id="1m" autocomplete="off" />
              <label class="btn btn-outline-primary" for="1m">1M</label>

              <input type="radio" class="btn-check" name="datetime" id="6m" autocomplete="off" />
              <label class="btn btn-outline-primary" for="6m">6M</label>
    
              <input type="radio" class="btn-check" name="datetime" id="1y" autocomplete="off" />
              <label class="btn btn-outline-primary" for="1y">1 Año</label>
    
              <input type="radio" class="btn-check" name="datetime" id="ytd" autocomplete="off" />
              <label class="btn btn-outline-primary" for="ytd">Último Año</label>

              <input type="radio" class="btn-check" name="datetime" id="all" autocomplete="off" />
              <label class="btn btn-outline-primary" for="all">Todo</label>

              <input type="radio" class="btn-check" name="datetime" id="date" autocomplete="off" />
              <label class="btn btn-outline-primary" for="date"> <i data-feather="calendar"></i> </label>
            </div>
        </div>
        <div class="card-body">
            <div id="line-chart"></div>
        </div>
    </div>
</div>