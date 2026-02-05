@vite(['resources/css/app.scss', 'resources/js/app.js'])

<!-- BEGIN: Vendor CSS-->
@if($configData['direction'] === 'rtl' && isset($configData['direction']))
<link rel="stylesheet" href="{{ asset('vendors/css/vendors-rtl.min.css') }}" />
@else
<link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
@endif

@yield('vendor-style')
<!-- END: Vendor CSS-->

<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">

<!-- BEGIN: Theme CSS (core, overrides, style, menu types in Vite bundle) -->

@php $configData = Helper::applClasses(); @endphp

<!-- BEGIN: Page CSS-->
{{-- Menu type CSS is in Vite bundle --}}
{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style (overrides in Vite bundle) -->

<!-- BEGIN: Custom CSS / RTL -->
@if($configData['direction'] === 'rtl' && isset($configData['direction']))
@vite(['resources/css/app-rtl.scss'])
@endif

<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/jquery-confirm/jquery-confirm.min.css') }}">
