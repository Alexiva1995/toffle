<script>

  numRows = 0;
  
  var ids = [];

  $( ".data_pivot_id" ).each(function() {
      ids.push( $( this ).data( "id" ) );
  });

  function addRow(type){

    var repeated = false;

    if ($("#selected_ingredient option:selected").val() == null || $("#selected_ingredient option:selected").val() == '' || $("#portion_dish").val() == null || $("#portion_dish").val() == '') {
        toastr['error']('', 'Debes seleccionar primero un ingrediente y la porcion, para luego añadirlo', {
              closeButton: true,
              tapToDismiss: false,
        });
    }else{

        for(var i = 0; i < ids.length; i++){
            if(ids[i] == $("#selected_ingredient option:selected").val() ){ 
              repeated = true;
            }           
        }
        if (!repeated) {
            ids.push( $("#selected_ingredient option:selected").val() );
            numRows++;
            var content = '';
            if (type == 'create') {
              content = '<tr id="row_'+numRows+'">\
                <td class="text-center">'+numRows+'</td>\
                <input type="hidden" name="ingredient_ids[]" class="form-control text-center dish_ids" id="dish_ids_'+numRows+'" value="'+$("#selected_ingredient option:selected").val()+'" required>\
                <td><input type="text" name="ingredient[]" class="form-control text-center dish" id="selected_ingredient_'+numRows+'" value="'+$("#selected_ingredient option:selected").text()+'" required readonly></td>\
                <td><input type="text" name="portion[]" class="form-control text-center price" id="portion_'+numRows+'" value="'+$("#portion_dish").val()+'" readonly required></td>\
                <td><input type="text" name="price[]" class="form-control text-center price data_pivot_price" id="price_'+numRows+'" value="'+$('#calculate_cost').val()+'" readonly required></td>\
                <td class="text-center"><a href="javascript:;" onclick="deleteRow('+numRows+')" style="color: #512F26;"><i style="color: #512F26;" data-feather="x-circle"></i> </a></td>\
                </tr>';
            }else{
              var content = '<tr id="row_'+numRows+'">\
                <td class="text-center">'+numRows+'</td>\
                <input type="hidden" name="ingredient_ids[]" class="form-control text-center dish_ids" id="dish_ids_'+numRows+'" value="'+$("#selected_ingredient option:selected").val()+'" required>\
                <td><input type="text" name="ingredient[]" class="form-control text-center dish" id="selected_ingredient_'+numRows+'" value="'+$("#selected_ingredient option:selected").text()+'" required readonly></td>\
                <td><input type="text" name="portion[]" class="form-control text-center" id="portion_'+numRows+'" value="'+$("#portion_dish").val()+'" readonly required></td>\
                <td><input type="text" name="price[]" class="form-control text-center price data_pivot_price" id="price_'+numRows+'" value="'+$('#calculate_cost').val()+'" readonly required></td>\
                <td class="text-center"><a class="btn btn-sm btn-danger" onclick="deleteIngredient('+numRows+')"> <i data-feather="trash-2"></i> </a></td>\
                </tr>';
            }

            $("#items_table>tbody").append(content);
            feather.replace();
            calculate();

        }else{
          toastr['error']('', 'Este ingrediente ya fue añadido', {
              closeButton: true,
              tapToDismiss: false,
          });
        }
    }
  }

  function calculate(row = null){
      var total = 0;
      var cost = 0;

      $( ".data_pivot_price" ).each(function() {
        total += parseFloat($(this).val());
      });

      // for (var i = 1; i <= numRows; i++){
      //   if ($("#price_"+i).val() != null ) {
      //     total += parseFloat($("#price_"+i).val());               
      //   }
      //   console.log($("#price_"+i).val());   
      // }

      total = cost + total;

      profit = $("#percentage_profit").val();
      cost = $("#cost_price").val( total.toFixed(2) );
      sugg = $("#suggested_price").val( (total * profit).toFixed(2) );
      $("#designated_price").val( (total * profit).toFixed(2) );

  }

  function deleteRow(row){
      for( var i = 0; i < ids.length; i++){ 
        if ( ids[i] === $("#dish_ids_"+row).val()) { 
          ids.splice(i, 1); 
        }
      }

      $("#row_"+row).remove();
      numRows--;

      calculate();
  }

  function caculateCost() {
      value = $('#portion_dish').val();
      cost = $('#selected_ingredient option:selected').data("cost");
      gr = $('#selected_ingredient option:selected').data("gr");
      unit = $('#selected_ingredient option:selected').data('unit');
      cost_ingredient =  parseFloat( (value * cost) / gr ).toFixed(2);
      $('#calculate_cost').val(cost_ingredient);
  }

  $(document).ready(function() {
      $('#portion_dish').keyup( function() {
          caculateCost();
      });

      $('#selected_ingredient').change( function() {
          caculateCost()
      });
  });
</script>