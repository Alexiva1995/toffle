  {{-- DataTables ya están en app.js (Vite): jQuery + DataTables + extensiones. No cargar de nuevo. --}}
  {{-- Flatpickr para páginas que lo usen en este panel --}}
  <script src="{{ asset('vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>

  {{-- Page js files (built by Vite); usan window.$ / window.jQuery del bundle app.js --}}
  @vite(['resources/js/scripts/tables/table-datatables-basic.js'])

<script>
    function dataTable(table_id) {
      var opts = { language: { url: '{!! asset('data/datatable/Spanish.json') !!}' } };
      function init() {
        if (typeof window.$ !== 'undefined' && typeof window.$.fn.DataTable !== 'undefined') {
          window.$(table_id).DataTable(opts);
        } else {
          setTimeout(init, 50);
        }
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
      } else {
        init();
      }
    }
</script>

