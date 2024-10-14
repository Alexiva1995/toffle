@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Empleados en Sesión')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">

                <div class="table-responsive">
                    <table class="table rounded border-table" id="table" >
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>IP</th>
                                <th>Usuario</th>
                                <th>Ultima actividad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                                <tr>
                                    <td>{{$session->user_agent}}</td>
                                    <td>{{$session->ip_address}}</td>
                                    <td>{{$session->user->getFullName()}}</td>
                                    <td>{{$session->getLastActivity()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection


@section('page-script')
    <!-- Page js files -->
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var tdStatus = data[5];
                var filterStatus = $('#status_filter option').filter(':selected').val();
                if (filterStatus == '') {
                    return true;
                }
                return tdStatus == filterStatus;
            }
        );

        $(document).ready(function() {
            var table = $('.table').DataTable();
            $('#status_filter').change( function() {
                table.draw();
            });
        });

        dataTable('#table');
    </script>
@endsection
