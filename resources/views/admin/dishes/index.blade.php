@extends('layouts/contentLayoutMaster')

@section('title', 'Platos')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <section id="nav-tabs-aligned">
            <div class="row match-height">
                <!-- Centered Aligned Tabs starts -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ Session::has('dishes') == true ? '' : 'active' }}"
                                        id="dishes-tab-center"
                                        data-bs-toggle="tab"
                                        href="#dishes-center"
                                        aria-controls="dishes-center"
                                        role="tab"
                                        aria-selected="false"
                                    >Platos</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ Session::has('dishes') == true ? 'active' : '' }}"
                                        id="ingredients-tab-center"
                                        data-bs-toggle="tab"
                                        href="#ingredients-center"
                                        aria-controls="ingredients-center"
                                        role="tab"
                                        aria-selected="false"
                                    >Ingredientes</a
                                    >
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane {{ Session::has('dishes') == true ? '' : 'active' }}" id="dishes-center" aria-labelledby="dishes-tab-center" role="tabpanel">
                                    @include('admin.dishes.list')
                                </div>
                                <div class="tab-pane {{ Session::has('dishes') == true ? 'active' : '' }}" id="ingredients-center" aria-labelledby="ingredients-tab-center" role="tabpanel">
                                    @include('admin.ingredients.list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
    <script src="{{asset('js/scripts/components/components-navs.js')}}"></script>
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        function submitForms (btn_id, load_class, form_id) {
            $(btn_id).click( function() {
                var this_button = $(this);
                this_button.attr('disabled', 'disabled').addClass('disabled');
                $(load_class).addClass('spinner-border spinner-border-sm');
                $(form_id).submit();
            });
        }

        submitForms('#add_dish', '.loading_btn_i', '#form_add_dish');
        submitForms('#update_dish', '.loading_btn_i', '#form_update_dish');
        submitForms('#add_ingredient', '.loading_btn_p', '#form_add_ingredient');

    </script>
@endsection
