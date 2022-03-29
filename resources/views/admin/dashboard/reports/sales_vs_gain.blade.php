<div class="col-12">
    <div class="card">
      <div class="card-header">
        <div>
          <h4 class="card-title mb-25">Informes de Ventas </h4>
        </div>
        <div class="row justify-content-end">
          <div class="col-auto">
            <div class="d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
              <div class="mt-md-0 mt-1 btn-group-checked" role="group" aria-label="Basic radio toggle button group">

                <input type="radio" class="btn-check" name="datetime" id="date_calendar" value="" autocomplete="off"/>
                <label class="btn btn-outline-primary" id="label-date-calendar" for="date_calendar"> <i data-feather="calendar"></i> </label>

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
                <label class="btn btn-outline-primary" for="ytd">Año hasta la Fecha (YTD)</label>
  
                <input type="radio" class="btn-check datetime" name="datetime" id="all" value="all" autocomplete="off" />
                <label class="btn btn-outline-primary" for="all">Todo</label>
              </div>
          </div>
          </div>
        </div>
      </div>

      <input type="hidden" id="amount_vs_gain_route" value="{{ route('data.chart.amount.vs.gain') }}">
      <input type="hidden" id="translate" data-es = "{{ file_get_contents(base_path('resources/data/apexcharts/locale/es.json')) }}">
      <input type="hidden" id="flatpickr_translate" data-es = "{{ file_get_contents(base_path('resources/data/flatpickr/locale/es.json')) }}">

      <div class="card-body">

            <div class="spinner2 d-none" id="spiner-chart">
              <div class="rect1"></div>
              <div class="rect2"></div>
              <div class="rect3"></div>
              <div class="rect4"></div>
              <div class="rect5"></div>
            </div>

            <div id="line-top-chart"></div>
            <div id="line-bottom-chart"></div>
      </div>
    </div>
</div>