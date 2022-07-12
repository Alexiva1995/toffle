@extends('layouts/contentLayoutMaster')

@section('title', 'Inventario')

@section('vendor-style')
    <!-- vendor css files -->
    @include('panels.datatable.styles')
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
                      class="nav-link {{ Session::has('products') == true ? '' : 'active' }}"
                      id="inventories-tab-center"
                      data-bs-toggle="tab"
                        href="#inventories-center"
                      aria-controls="inventories-center"
                      role="tab"
                      aria-selected="false"
                      >Inventario</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link {{ Session::has('products') == true ? 'active' : '' }}"
                      id="products-tab-center"
                      data-bs-toggle="tab"
                      href="#products-center"
                      aria-controls="products-center"
                      role="tab"
                      aria-selected="false"
                      >Productos</a
                    >
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane {{ Session::has('products') == true ? '' : 'active' }}" id="inventories-center" aria-labelledby="inventories-tab-center" role="tabpanel">
                    @include('admin.inventory.list')
                  </div>
                  <div class="tab-pane {{ Session::has('products') == true ? 'active' : '' }}" id="products-center" aria-labelledby="products-tab-center" role="tabpanel">
                    @include('admin.products.list')
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
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Inventory
    //Se comento la siguiente función para hacer las modificaciones al form (G-2.0 Inventario)
    // submitForms('#add_inventory', '.loading_inv', '#form_add_inventory');
    submitForms('#aggregate_product', '.loading_aggr_p', '#form_aggregate_product');
    submitForms('#edit_inventory', '.loading_edit_inv', '#form_edit_inventory');
    //Versión adaptada al nuevo formulario
    submitForms('#edit_inventory_2', '.loading_edit_inv', '#form_edit_inventory_2');

    // Sum an Subtract
    submitForms('#btn_operation', '.loading_op', '#form_operation');

    // Product
    submitForms('#add_product', '.loading_btn_p', '#form_add_product');
    submitForms('#edit_product', '.loading_edit_p', '#form_edit_product');

    function editProduct(id, name, cant_type, quantity, flavors) {
      var route = '{{route('products.update', 'replace_this')}}'.replace('replace_this', id);
      $('#form_edit_product').attr('action', route);
      $('#edit_name').val(name);
      $('#edit_quantity').val(quantity);
      $('#cant_type').text(cant_type);
      $('#typeOfCant').val(cant_type);

      if (flavors == true) {
        $("#edit_flavors").prop("checked", true);
      }else{
        $("#edit_flavors").prop("checked", false);
      }

      $('#modal_edit_product').modal('show');
    }

    function editInventory(id, product_id, qty_package, unit_package, price, cost, deposit, local, public, total) {

      var route = '{{route('inventory.update', 'replace_this')}}'.replace('replace_this', id);
      $('#form_edit_inventory').attr('action', route);
      $("#edit_product_id option[value="+ product_id +"]").attr("selected", 'selected').trigger('change');
      $('#edit_qty_package').val(qty_package);
      $('#edit_unit_package').val(unit_package);
      $('#edit_price').val(price);
      $('#edit_cost').val(cost);
      $('#edit_deposit').val(deposit);
      $('#edit_local').val(local);
      $('#edit_public').val(public);
      $('#edit_total').val(total);
      $('#modal_edit_inventory').modal('show');

    }

    function editInventoryWithoutPackage(id, product_id, unit_package, price, cost, deposit, local, public, total) {
      var route = '{{route('inventory.update', 'replace_this')}}'.replace('replace_this', id);
      $('#form_edit_inventory_2').attr('action', route);
      $("#edit_product_id option[value="+ product_id +"]").attr("selected", 'selected').trigger('change');
      $('#edit_unit_package_2').val(unit_package);
      $('#edit_price_2').val(price);
      $('#edit_cost_2').val(cost);
      $('#edit_deposit_2').val(deposit);
      $('#edit_local_2').val(local);
      $('#edit_public_2').val(public);
      $('#edit_total_2').val(total);
      $('#modal_edit_inventory_2').modal('show');
    }

    function operation(department, operator, id, max_value = 0) {
      var title = '';
      var btn_text = '';

      var route = "{{ route('operation.inventory', 'id') }}";
      route = route.replace('id', id);
      $('#form_operation').attr('action', route);

      if (operator == 'subtract') {
        btn_text = "Restar" ;
      }

      if (operator == 'sum') {
        btn_text = "Sumar" ;
      }

      switch (department) {
        case 'deposit':
          title = btn_text+" Depósito" ;
          break;
        case 'local':
          title = btn_text+" Local" ;
          break;
        case 'public':
          title = btn_text+" Público" ;
          break;
      
        default:
          break;
      }       

      $('#modal_title').text(title);
      $('#btn_text').text(btn_text);
      $('#department').val(department); 
      $('#operation').val(operator);   
      $('#qty').val('');
      $('#max_value').val(max_value);   
      $("#modal_operation").modal("show");
    }

    function calculateCost() {
      var unit_package = $('#edit_unit_package').val();
      var price = $('#edit_price').val();

      var cost = price / unit_package;
      cost = roundDecimal(cost, 2);
      $('#edit_cost').val(cost);
    }

    //Calcular el costo a inventario despues de las modificaciones (G-2.0 Inventario)
    function calculateCost2() {
      var unit_package = $('#edit_unit_package_2').val();
      var price = $('#edit_price_2').val();

      var cost = price / unit_package;
      cost = roundDecimal(cost, 2);
      $('#edit_cost_2').val(cost);
    }

    function calculateTotal() {
      var deposit = $('#edit_deposit').val();
      var local = $('#edit_local').val();
      var public = $('#edit_public').val();

      var total = parseFloat(deposit = null ? 0 : deposit) + parseFloat(local = null ? 0 : local) + parseFloat(public = null ? 0 : public);
      $('#edit_total').val(total);
    }
    //Calcular el total a inventario despues de las modificaciones (G-2.0 Inventario)
    function calculateTotal2() {
      var deposit = $('#edit_deposit_2').val();
      var local = $('#edit_local_2').val();
      var public = $('#edit_public_2').val();

      var total = parseFloat(deposit = null ? 0 : deposit) + parseFloat(local = null ? 0 : local) + parseFloat(public = null ? 0 : public);
      $('#edit_total_2').val(total);
    }
    //Filtro para que el campo "unidades" solo acepte números enteros 
    function filter() {
      var key = event.key;
      if ( ['.','e'].includes(key) ){
        event.preventDefault()
      }
    }
    //función para limitar decimales a 2
    function decimalLimit (numero) {
      //Convertir string a numero
      numero = parseFloat(numero);
      //Limita a 2 decimales 
      numero = numero.toFixed(2);
      //convierte el string devuelto a numero
      numero = parseFloat(numero);
      
      return numero;
    }

    $(document).ready(function() {
      
      dataTable('#table');
      dataTable('#product_table');

      $('#btn_max').click( function() {
        $('#qty').val( $('#max_value').val() );
          toastr['success']('', 'Cantidad Máxima Agregada', {
          closeButton: true,
          tapToDismiss: false,
        });
      });

      $('#create_product_id').change( function() {
        var flavor = $("option:selected", this).data('flavor');
        $("#it_has_flavors").val(flavor);

        if (flavor == true) {
          $('.flavor-name').removeClass('d-none');
        }else{
          $('.flavor-name').addClass('d-none');
        }
      });
      //Oculta los inputs ya que COP es marcado por default
      if( $('#radio_COP').is(':checked'))
      {
        $('#dolar_cop').css('display', 'none');
        $('#dolar_bs').css('display', 'none');
      }
      //Mostrar - Ocultar inputs segun el radio
      $('#radio_COP').click(function(){
        $('#dolar_cop').css('display', 'none');
        $('#dolar_cop_price').val('');
        $('#dolar_bs').css('display', 'none');
        $('#dolar_bs_price').val('');
        //vaciar campo precio y cambiar placeholder
        $('#create_price').val('');
        $('#create_price').attr("placeholder", "Precio en COP");
      });

      $('#radio_USD').click(function(){
        $('#dolar_cop').css('display', 'block');
        $('#dolar_bs').css('display', 'none');
        $('#dolar_bs_price').val('');
        //vaciar campo precio y cambiar placeholder
        $('#create_price').val('');
        $('#create_price').attr("placeholder", "Precio en USD");
      });

      $('#radio_BS').click(function(){
        $('#dolar_cop').css('display', 'block');
        $('#dolar_bs').css('display', 'block');
        //vaciar campo precio y cambiar placeholder
        $('#create_price').val('');
        $('#create_price').attr("placeholder", "Precio en Bs");
      });
    });
  </script>
  <script>
    // Calcular precio del producto
    $('#add_inventory').click(function() {
      let cop_radio = $('#radio_COP');
      let usd_radio = $('#radio_USD');
      let bs_radio = $('#radio_BS');
      let iva_check = $('#checkbox_iva');
      let unit_cost = $('#unit_cost');
      let input_price = $('#create_price');
      let product_select = $('#create_product_id').val();
      var unit_product_price;
      var unit_product_usd_bs_price;
      var inventory_cop_price;
      let form = $('#form_add_inventory');

      let product_units =  $('#create_unit_package').val();
      if(product_units != '') { product_units = parseFloat(product_units); }

      let product_price = $('#create_price').val();
      if(product_price != ''){ product_price = parseFloat(product_price); }

      if( product_price == '' || product_units == '' || product_select == null )
      {
        return Swal.fire({
          icon: 'error',
          title: 'Oops...',
          confirmButtonColor: '#FF5933',
          html: '<b>Es Necesario que todos los campos esten llenos!</b>',
        });
      }
      //Obtener valor del producto unitario en USD
      unit_product_usd_bs_price = product_price / product_units;
      unit_product_usd_bs_price = decimalLimit(unit_product_usd_bs_price);
      
      //trabajar en reacción al tipo de moneda seleccionado, por default es COP
      // USD
      if( usd_radio.is(':checked') )
      {
        var dolar_cop_price = $('#dolar_cop_price').val();
        if(dolar_cop_price != '')
        {
          dolar_cop_price = parseFloat(dolar_cop_price);
        } else { 
          return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            confirmButtonColor: '#FF5933',
            html: '<b>Debe igresar el valor del Dolar en Pesos!</b>',
          });
        }

        product_price = product_price * dolar_cop_price;
        //Obtener el costo del inventario en COP en relacion al dolar
        inventory_cop_price = decimalLimit(product_price);
      }
      //Precio original sin modificar
      var raw_product_price = decimalLimit(product_price);
      //BS
      if( bs_radio.is(':checked') )
      {
        var dolar_bs_price = $('#dolar_bs_price').val();
        var dolar_cop_price = $('#dolar_cop_price').val();
        if(dolar_bs_price != '' && dolar_cop_price != '')
        {
          dolar_bs_price = parseFloat(dolar_bs_price);
          dolar_cop_price = parseFloat(dolar_cop_price);
        } else { 
          return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            confirmButtonColor: '#FF5933',
            html: '<b>Debe igresar el valor del Dolar tanto en Pesos como en Bolivares!</b>',
          });
        }
        
        //Obtener costo unitario en COP en relacion al dolar
        product_price = (product_price / dolar_bs_price);
        product_price = (product_price * dolar_cop_price);
        //Obtener costo del inventario en COP en relacion al Bs
        inventory_cop_price = ( raw_product_price / dolar_bs_price);
        inventory_cop_price = decimalLimit(inventory_cop_price);
        inventory_cop_price *= dolar_cop_price;
      }
      if( cop_radio.is(':checked') )
      {
        inventory_cop_price = input_price.val();
        inventory_cop_price = decimalLimit(inventory_cop_price);
      }

      //Verifica si incluye el Iva y actua en consecuencia
      if( iva_check.is(':checked') )
      {
        var final_product_price = (raw_product_price * 1.19) / product_units;
        final_product_price = decimalLimit(final_product_price);
        inventory_cop_price = (inventory_cop_price * 1.19)
        inventory_cop_price = decimalLimit(inventory_cop_price);
      }else{
        var final_product_price = inventory_cop_price / product_units;
        final_product_price = decimalLimit(final_product_price);
      }

      /* Precio unitario final sin iva */
      unit_product_price = product_price / product_units;
      unit_product_price = decimalLimit(unit_product_price);
      //Alerta para mostrar y confirmar datos segun lo seleccionado
      if( bs_radio.is(':checked') )
      {
        let input_price_in_bs_dollar = raw_product_price / dolar_bs_price;
        input_price_in_bs_dollar = decimalLimit(input_price_in_bs_dollar);
        let item_price_dolar_bs = decimalLimit(unit_product_usd_bs_price / dolar_bs_price);
        if( iva_check.is(':checked') )
        {
          let inventory_semiFinalPrice = decimalLimit(input_price_in_bs_dollar * dolar_cop_price);
          inventory_cop_price = decimalLimit(inventory_cop_price);
          final_product_price = decimalLimit(inventory_cop_price / product_units);
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario en COP es: $${inventory_cop_price}</b>
              <br>
              <b>Operación: </b>
              <br>
              <b> Precio ingresado: ${input_price.val()} / Bs dolar: ${dolar_bs_price} =</b>
              <br>
              <b>USD: $${input_price_in_bs_dollar}</b>
              <br>
              <b> USD: ${input_price_in_bs_dollar} * (COP dolar: ${dolar_cop_price}) =</b>
              <br>
              <b>COP: $${inventory_semiFinalPrice}</b>
              <br>
              <b>Se aplicará el iva de 19%</b>
              <br>
              <b>Costo del inventario * 1.19</b>
              <br>
              <b>${inventory_semiFinalPrice} * 1.19 = ${inventory_cop_price}<b>
              <br>
              <b>El precio del producto unitario seria: COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });

        } else {
          final_product_price = decimalLimit(inventory_cop_price / product_units);
          inventory_cop_price = decimalLimit(inventory_cop_price);
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario en COP es: $${inventory_cop_price}</b>
              <br>
              <b>Operación: </b>
              <br>
              <b> Precio ingresado: ${input_price.val()} / Bs dolar: ${dolar_bs_price} =</b>
              <br>
              <b>$${input_price_in_bs_dollar} dolares</b>
              <br>
              <b>${input_price_in_bs_dollar} * (COP dolar: ${dolar_cop_price}) = ${inventory_cop_price}</b>
              <br>
              <b>El precio del producto unitario seria:</b>
              <br>
              <b>COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });
        }
      }

      if( usd_radio.is(':checked') )
      {
        if( iva_check.is(':checked') )
        {
          let price_val = input_price.val();
          price_val = decimalLimit(price_val);
          let inventory_semiFinalPrice = decimalLimit(price_val * dolar_cop_price);
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario en COP es: $${inventory_cop_price}</b>
              <br>
              <b>Operación: </b>
              <br>
              <b>Precio ingresado * Valor del dolar = Costo del inventario en COP</b>
              <br>
              <b>${input_price.val()} * ${dolar_cop_price} = ${inventory_semiFinalPrice}</b>
              <br>
              <b>Se aplicará el iva de 19%</b>
              <br>
              <b>Costo del inventario * 1.19</b>
              <br>
              <b>${inventory_semiFinalPrice} * 1.19 = ${inventory_cop_price}<b>
              <br>
              <b>El precio del producto unitario seria: COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });

        } else {
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario en COP es: $${inventory_cop_price}</b>
              <br>
              <b>Operación: </b>
              <br>
              <b>Precio ingresado * Valor del dolar = Costo del inventario en COP</b>
              <br>
              <b>${input_price.val()} * ${dolar_cop_price} = ${inventory_cop_price}</b>
              <br>
              <b>El precio del producto unitario seria:</b>
              <br>
              <b>COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });
        }
      }
      
      if( cop_radio.is(':checked') )
      {
        if( iva_check.is(':checked') )
        {
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario base es: COP$ ${product_price}</b>
              <br>
              <b>Se aplicará el iva de 19%</b>
              <br>
              <b>Costo del inventario * 1.19</b>
              <br>
              <b>${product_price} * 1.19 = ${inventory_cop_price}<b>
              <br>
              <br>
              <b>El costo del inventario con iva es: COP$ ${inventory_cop_price}</b>
              <br>
              <b>El precio del producto unitario seria: COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });
        } else {
          Swal.fire({
            title: '¿Quieres añadir este nuevo inventario?',
            html: `<b>El costo del inventario es: COP$ ${inventory_cop_price}</b>
              <br>
              <b>El precio del producto unitario seria: COP$ ${final_product_price}</b>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF5933',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Editar',
            confirmButtonText: '¡Confirmar!',
          }).then((result) => {
            if (result.isConfirmed) {
              unit_cost.val(final_product_price);
              input_price.val(inventory_cop_price);
              form.submit();
            }
          });
        }
      }

    });
  </script>
@endsection