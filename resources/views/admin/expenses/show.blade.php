@extends('layouts/contentLayoutMaster')

@section('title', 'Detalles de Gasto')

@include('panels.datatable.styles')

@section('vendor-style')
    <!-- vendor css files -->
@endsection

@section('page-style')
@endsection

@section('content')
<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('expenses.list') }}">
                                    Gastos
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                Detalles
                            </li>
                        </ol>
                  </div>
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="row my-3">
                            <div class="col-auto">
                                <h5>Fecha: <span class="h6"> {{ $expense_details->date }} </span> </h5> 
                            </div>
                            <div class="col-auto">
                                <h5>Día <span class="h6"> {{ $expense_details->getDay($expense_details->date) }} </span> </h5>
                            </div>
                            <div class="col-auto">
                                <h5>Monto Total: <span class="h6"> {{ $expense_details->amount }} </span> </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">N°</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $expense->description }}</td>
                                <td class="text-center">{{ $expense->amount}}</td>
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
    <!-- vendor files -->
    <script src="{{ asset('vendors/js/jquery/jquery.min.js') }}"></script>
@endsection

@section('page-script')
    <!-- Page js files -->
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        dataTable('#table');
    </script>
@endsection