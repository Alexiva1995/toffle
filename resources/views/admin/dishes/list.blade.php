@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Platos')

@section('vendor-style')
    @include('panels.datatable.styles')
@endsection

@section('content')
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card p-2">
                <div class="row mb-2">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            {{-- FILTRO DE ESTATUS --}}
                            <div class="col-12 col-md-6">
                                <label for="status">Filtrar Estados</label>
                                <select class="form-select" data-toggle="select" name="status"
                                    id="status_filter">
                                    <option value="">Todas los Estados</option>
                                    <option value="Activo">Activos</option>
                                    <option value="Inactivo">Inactivos</option>
                                    <option value="En Revisión">En Revision</option>
                                </select>
                            </div>

                            {{-- FILTRO DE CATEGORÍA --}}
                            <div class="col-12 col-md-6">
                                <label for="category">Filtrar Categoría</label>
                                <select class="form-select" data-toggle="select" name="category"
                                    id="category_filter">
                                    <option value="">Todas las Categorías</option>
                                    {{-- Recorre las categorías obtenidas del controlador --}}
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row justify-content-end mt-1">
                            <div class="col-auto">
                                <a href="{{ route('dishes.create') }}" class="btn btn-primary mt-2">
                                    <i data-feather="plus"></i> Añadir Plato
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table rounded border-table border-primary" id="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Costo Total</th>
                                <th>CPV</th>
                                <th>Precio Sugerido</th>
                                <th>Precio Designado</th>
                                <th>Categoría</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <span class="badge badge-light-{{ $item->statusColor() }}">
                                        {{ $item->status() }}
                                    </span>
                                </td>
                                <td>{{ number_format($item->cost_price, 2) }}</td>
                                <td>
                                    @if ($item->cpv !== null)
                                        {{ number_format($item->cpv, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ number_format($item->suggested_price, 2) }}</td>
                                <td>{{ number_format($item->designated_price, 2) }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>
                                    <a href="{{ route('dishes.edit', $item->id) }}" class="btn btn-sm btn-info my-1">
                                        @include('partials.edit_icon_svg')
                                    </a>

                                    <button class="btn btn-sm btn-danger"
                                    onclick="deleteElement( {{ $item->id }},
                                    '#delete_dish_',
                                    'este Plato',
                                    'IMPORTANTE: Si esté plato está registrado en un pedido, no podrá ser removido' )">
                                        @include('partials.trash_icon_svg')
                                    </button>

                                    <form id="delete_dish_{{ $item->id }}" action="{{ route('dishes.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
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
@endsection

@section('custom-js')
    @include('panels.datatable.scripts')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable con configuración mejorada
            let table = $('#table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                "responsive": true,
                "order": [[0, 'desc']],
                "columnDefs": [
                    {
                        "targets": [0], // Columna ID
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [2], // Columna Estado
                        "render": function(data, type, row) {
                            // Para búsqueda y ordenamiento, extrae solo el texto del estado
                            if (type === 'sort' || type === 'filter') {
                                // Extraer el texto del badge (el estado real)
                                let tempDiv = document.createElement('div');
                                tempDiv.innerHTML = data;
                                let badgeText = tempDiv.querySelector('.badge')?.textContent?.trim();
                                return badgeText || data;
                            }
                            // Para visualización, devuelve el HTML original
                            return data;
                        }
                    }
                ]
            });

            // FILTRO DE ESTATUS - Mejorado
            $('#status_filter').on('change', function () {
                let searchTerm = $(this).val();
                if (searchTerm) {
                    // Usar expresión regular para coincidencia exacta
                    table.column(2).search('^' + searchTerm + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });

            // FILTRO DE CATEGORÍA
            $('#category_filter').on('change', function () {
                let searchTerm = $(this).val();
                if (searchTerm) {
                    table.column(7).search('^' + searchTerm + '$', true, false).draw();
                } else {
                    table.column(7).search('').draw();
                }
            });
        });
    </script>
@endsection
