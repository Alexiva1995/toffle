@extends('layouts/contentLayoutMaster')

@section('title', 'Pedidos')

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
<div id="logs-list">
    <div class="col-12">
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <form action="" method="GET">
                    @csrf
                        <div class="row g-0 justify-content-end">
                            <div class="col-2">
                                <input type="date" id="fecha_ini" name="fecha_ini" class="form-control flatpickr-basic rounded border-primary" placeholder="fecha inicial" @if(Request::get('fecha_ini') != null) value="{{Request::get('fecha_ini')}}" @endif required/>
                            </div>
                            <div class="col-2">
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control flatpickr-basic rounded border-primary" placeholder="fecha final" @if(Request::get('fecha_fin') != null) value="{{Request::get('fecha_fin')}}" @endif required/>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <div>
                        <table class="table myTable table-striped">
                            <thead class="">
                                <tr class="text-center ">
                                    <th>#</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($pedidos as $pedido)
                                <tr class="text-center">
                                    <td>{{$pedido->id}}</td>
                                    <td>{{$pedido->total_amount}}</td>
                                    <td>{{$pedido->estado()}}</td>
                                    <td>{{$pedido->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDetalles{{$pedido->id}}">Detalles</button>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="modalDetalles{{$pedido->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h1>{{$pedido->dishes}}}</h1>
                                            {{--
                                            @foreach ($pedido->dishes as $detalle)
                                                <tr class="text-center">
                                                    <td></td>
                                                    <td>{{$detalle->unit}}</td>
                                                    <td>{{$detalle->price}}</td>
                                                </tr>
                                            @endforeach
                                            --}}
                                            {{--
                                            <table class="table myTable table-striped">
                                                <thead class="">
                                                    <tr class="text-center ">
                                                        <th>Plato</th>
                                                        <th>cantidad</th>
                                                        <th>precio</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pedido->dishes as $detalle)
                                                        <tr class="text-center">
                                                            <td></td>
                                                            <td>{{$detalle->unit}}</td>
                                                            <td>{{$detalle->price}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            --}}
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
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
