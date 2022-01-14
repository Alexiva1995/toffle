<div class="col-12">
    <div class="card">
      <div class="card-header">
        <div>
          <h4 class="card-title mb-25">Informes de Ventas </h4>
        </div>
        <div class="row justify-content-end">
          <div class="col-auto">
            <div class="d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
              <div class="mt-md-0 mt-1" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check datetime" name="datetime" id="1d" value="1day" autocomplete="off" checked />
                <label class="btn btn-outline-primary" for="1d">1D</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="7d" value="7day" autocomplete="off" />
                <label class="btn btn-outline-primary" for="7d">7D</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="1m" value="1month" autocomplete="off" />
                <label class="btn btn-outline-primary" for="1m">1M</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="6m" value="6month" autocomplete="off" />
                <label class="btn btn-outline-primary" for="6m">6M</label>
      
                <input type="radio" class="btn-check datetime" name="datetime" id="1y" value="1year" autocomplete="off" />
                <label class="btn btn-outline-primary" for="1y">1 Año</label>
      
                <input type="radio" class="btn-check datetime" name="datetime" id="ytd" value="ytd" autocomplete="off" />
                <label class="btn btn-outline-primary" for="ytd">Año hasta Fecha Actual (YTD)</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="all" value="all" autocomplete="off" />
                <label class="btn btn-outline-primary" for="all">Todo</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="date_calendar" value="date_calendar" autocomplete="off" />
                <label class="btn btn-outline-primary" for="date_calendar"> <i data-feather="calendar"></i> </label>
              </div>
          </div>
          </div>
        </div>
      </div>
      <div class="card-body" id="translate" data-es = "{{ file_get_contents(base_path('resources/data/apexcharts/locale/es.json')) }}">

            <div class="spinner2 d-none" id="spiner-chart">
              <div class="rect1"></div>
              <div class="rect2"></div>
              <div class="rect3"></div>
              <div class="rect4"></div>
              <div class="rect5"></div>
            </div>
            <div id="show-chart-tolbar">
              <div id="line-chart"></div>
              <div id="line-chart-2"></div>
            </div>
            {{-- <canvas class="line-chart-ex chartjs" data-height="450"></canvas> --}}
      </div>
    </div>
</div>