<!-- Modal Add Inventory-->
<div class="modal fade text-start" id="modal_add_dish" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Añadir Plato</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('admin.dishes.create')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add_dishe">
                    <span class="loading_inv mr-2"></span> Añadir
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Inventory-->
<div class="modal fade text-start" id="modal_edit_inventory" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Editar Inventario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- @include('admin.dishes.edit') --}}
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="edit_inventory">
                    <span class="loading_edit_inv mr-2"></span> Editar
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>

  submitForm('#add_dishe','#form_add_order');

  $
  numRows = 0;
  
  var ids = [];

  function addRow(){

    var repeated = false;

    if ($("#selected_dish option:selected").val() == null || $("#selected_dish option:selected").val() == '') {
        toastr['error']('', 'Debes seleccionar primero un plato, para luego añadirlo', {
              closeButton: true,
              tapToDismiss: false,
        });
    }else{

        for(var i = 0; i < ids.length; i++){
            if(ids[i] == $("#selected_dish option:selected").val() ){ 
              repeated = true;
            }           
        }

        if (!repeated) {
            ids.push( $("#selected_dish option:selected").val() );
            numRows++;
            let content = '<tr id="row_'+numRows+'">\
            <td><input type="text" name="dish[]" class="form-control dish" id="dish_'+numRows+'" value="'+$("#selected_dish option:selected").text()+'" required disabled></td>\
            <input type="hidden" name="dish_ids[]" class="form-control dish_ids" id="dish_ids_'+numRows+'" value="'+$("#selected_dish option:selected").val()+'" required>\
            <td><input type="number" name="unit[]" class="form-control units" id="unit_'+numRows+'" value="1" oninput="calculate('+numRows+')" required></td>\
            <td><input type="text" name="price[]" class="form-control price" id="price_'+numRows+'" value="0" oninput="calculate('+numRows+')" required></td>\
            <td><input type="text" name="total[]" class="form-control total" id="total_'+numRows+'" value="0" readonly></td>\
            <td><a href="javascript:;" onclick="deleteRow('+numRows+')"> <i class="text-danger" data-feather="x-circle"></i> </a></td>\
            </tr>';
            $("#items_table>tbody").append(content);
            feather.replace();
        }else{
          toastr['error']('', 'Este Plato ya fue añadido', {
              closeButton: true,
              tapToDismiss: false,
          });
        }
    }
  }

  function deleteRow(row){
      $("#row_"+row).remove();
      numRows--;
  }

  function calculate(row){
      let unit = $("#unit_"+row).val();
      let price = $("#price_"+row).val();

      $("#total_"+row).val(parseInt(unit) * parseFloat(price));
      var total = 0;

      for (var i = 1; i <= numRows; i++){
          total += parseFloat($("#total_"+i).val());
      }

      $("#total").val(total);
      $("#total_amount").val(total);
  }
</script>