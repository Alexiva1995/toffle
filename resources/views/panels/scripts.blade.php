<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset(mix('vendors/js/ui/jquery.sticky.js'))}}"></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset(mix('js/core/scripts.js')) }}"></script>

@if($configData['blankPage'] === false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
@endif
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->

<script type="text/javascript">
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }

      @if(session('success'))  
          toastr['success']('{{ session('success') }}', '¡Exitoso!', {
                  closeButton: true,
                  tapToDismiss: false
              });
      @endif

      @if(session('danger'))
          toastr['error']('{{ session('danger') }}', 'Error', {
                  closeButton: true,
                  tapToDismiss: false
              });
      @endif

      @if(session('warning'))
          toastr['warning']('{{ session('warning') }}', 'Advertenecia', {
                  closeButton: true,
                  tapToDismiss: false
              });
      @endif

      @if(session('info'))
          toastr['info']('{{ session('info') }}', 'Informacion', {
                  closeButton: true,
                  tapToDismiss: false
              });
      @endif

      @if(isset($errors))
        @foreach ($errors->all() as $message)
          toastr['error']('{{ $message }}', 'Validación fallida', {
                  closeButton: true,
                  tapToDismiss: false
              });
        @endforeach
      @endif
    })
  </script>

<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
</script>

@yield('page-script')
<!-- END: Page JS-->
