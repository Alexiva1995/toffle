<!-- Company Table Card -->
<div class="card card-company-table">
    <div class="card-header">
        <h3>
            <div class="avatar bg-light-info">
                <div class="avatar-content icon-wrapper">
                    <i data-feather="eye"></i>
                </div>
            </div>
            Platos en Revisión (Precio Sugerido mayor al Precio Designado)
        </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="dishes_under_review_table">
                <thead>
                    <tr>
                        <th class="text-center px-0">Id</th>
                        <th class="text-center px-0">Plato</th>
                        <th class="text-center px-0">Precio Sugerido</th>
                        <th class="text-center px-0">Precio Designado</th>
                        <th class="text-center px-0">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dishes_under_review as $dish)
                        <tr>
                            <td class="text-center text-dark"> 
                                {{ $dish->id }}
                            </td>  
                            <td class="text-center text-dark"> 
                                {{ $dish->name }}
                            </td>  
                            <td class="text-center text-dark"> 
                                {{ $dish->suggested_price }}
                            </td>  
                            <td class="text-center text-dark"> 
                                {{ $dish->designated_price }}
                            </td>  
                            <td class="text-center"> 
                                <a href="{{ route('dishes.edit', $dish->id) }}" class="btn btn-info">
                                    <i data-feather="edit"></i> Revisar
                                </a>
                            </td>                    
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Company Table Card -->