@extends('layouts/contentLayoutMaster')

@section('title', 'Informes')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row match-height">
        <!-- Centered Aligned Tabs starts -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-6">
                                        <h3>Informe de lo mas vendido</h1>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table myTable table-striped">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Categoria</th>
                                                <th># de Ventas</th>
                                                <th>Ganancia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($dishes as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->categoriy_id }}</td>
                                                    <td>{{ $item->name_count}}</td>
                                                    <td>{{ $item->percentage_profit }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('custom-js')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script>
         $('.myTable').DataTable({
            responsive: true,
            order: [
                [0, "desc"]
            ],
        })
    </script>
@endsection
