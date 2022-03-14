@extends('layouts/contentLayoutMaster')

@section('title', $type == 'flow_days' ? 'Flujo del día' : 'Pedidos')

@section('vendor-style')
<!-- vendor css files -->
@include('panels.datatable.styles')
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
                    <div class="table-responsive"> 
                        <table class="table" id="orders_table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Monto</th>
                                    @if (Auth::user()->role == '1')
                                        <th class="text-center">Ganancia</th>
                                    @endif
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->total_amount}}</td>
                                        @if (Auth::user()->role == '1')
                                            <td class="text-center">{{$order->getProfitPerOrder($order->id)}}</td>
                                        @endif
                                        <td class="text-center">
                                            <span class="badge badge-light-{{ $order->colorStatus() }}"> 
                                                {{$order->estado()}}
                                            </span> 
                                        </td>
                                        <td class="text-center">{{$order->created_at->format('d/m/Y')}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDetalles{{$order->id}}">Detalles</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalDetalles{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table">
                                                                <thead class="">
                                                                    <tr class="text-center ">
                                                                        <th>Plato</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Precio por Unidad</th>
                                                                        <th>Precio Total</th>
                                                                        @if (Auth::user()->role == '1')
                                                                            <th>Ganancia por Unidad</th>
                                                                            <th>Ganancia Total</th>
                                                                        @endif
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order->dishes as $detail)
                                                                    <tr class="text-center">
                                                                        <td>{{$detail->name}}</td>
                                                                        <td>{{$detail->pivot->unit}}</td>
                                                                        <td>{{$detail->pivot->price}}</td>
                                                                        <td>{{ round($detail->pivot->price * $detail->pivot->unit, 2) }}</td>
                                                                        @if (Auth::user()->role == '1')
                                                                            <td>{{ round($detail->pivot->price - $detail->pivot->cost, 2) }}</td>
                                                                            <td>{{ round( ($detail->pivot->price - $detail->pivot->cost) * $detail->pivot->unit, 2)  }}</td>
                                                                        @endif
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
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
    @include('panels.datatable.scripts')
    <script>
        dataTable('#orders_table');
    </script>
@endsection
