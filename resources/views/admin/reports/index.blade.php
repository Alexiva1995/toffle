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
                                        <h3>Lista de Informes</h1>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table myTable table-striped">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Fecha</th>
                                                <th>Categoria</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($reports as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>{{ $item->categorie }}</td>
                                                    @if ($item->status == 0)
                                                        <td>En espera</td>
                                                    @elseif ($item->status == 1)
                                                        <td>Aprobado</td>
                                                    @elseif ($item->status == 2)
                                                        <td>Cancelado</td>
                                                    @endif
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
