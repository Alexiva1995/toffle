<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- END: Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('vendors/js/ui/jquery.sticky.js') }}"></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- Theme JS (app-menu, app, scripts, customizer, form-select2 in Vite bundle) -->

@yield('page-script')
<!-- END: Page JS-->

<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>

@include('panels.custom.scripts')

@yield('custom-js')
