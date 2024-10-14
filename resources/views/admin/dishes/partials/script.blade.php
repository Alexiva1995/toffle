<script>

  numRows = 0;
  
  var ids = [];

  $( ".data_pivot_id" ).each(function() {
      ids.push( $( this ).data( "id" ) );
  });
  //obtener radio buttos
  var waffle_radio = $('#waffle_radio');
  var half_waffle_radio = $('#half_waffle_radio');
  var quarter_waffle_radio = $('#quarter_waffle_radio');
  var bubble_radio = $('#bubble_radio');
  var toffle_palito_radio = $('#toffle_palito_radio');
  
  function dishBase(data){
    if( ids.length == 0 )
    {
      data.forEach(ingredient => {
        ids.push(`ingredient_${ingredient.id}`);
        numRows++;

        let content = '';
        // console.log((ingredient.cost / 1000) * ingredient.quantity);
        let cost = ((ingredient.cost * ingredient.amount) / parseFloat(ingredient.quantity)).toFixed(2);
        content = `
        <tr id="row_${numRows}">
          <td class="text-center">${numRows}</td>
          <input type="hidden" name="ingredient_ids[]" class="form-control text-center dish_ids" id="dish_ids_${numRows}" value="ingredient_${ingredient.id}" required>
          <td><input type="text" name="ingredient[]" class="form-control text-center dish" id="selected_ingredient_${numRows}" value="${ingredient.name}" required readonly></td>
          <td><input type="text" name="portion[]" class="form-control text-center price" id="portion_${numRows}" value="${ingredient.amount}" readonly required></td>
          <td><input type="text" name="price[]" class="form-control text-center price data_pivot_price" id="price_${numRows}" value="${cost}" readonly required></td>
          <td class="text-center"><a href="javascript:;" onclick="deleteRow(${numRows})" style="color: #512F26;"><i style="color: #512F26;" data-feather="x-circle"></i> </a></td>
        </tr>`;

        //Deshabilitar radio buttons
        waffle_radio.prop('disabled', true);
        half_waffle_radio.prop('disabled', true);
        quarter_waffle_radio.prop('disabled', true);
        bubble_radio.prop('disabled', true);
        toffle_palito_radio.prop('disabled', true);
        
        $("#items_table>tbody").append(content);
        feather.replace();
        calculate();
      });

    }else{

      waffle_radio.prop('checked', false);
      half_waffle_radio.prop('checked', false);
      quarter_waffle_radio.prop('checked', false);
      bubble_radio.prop('checked', false);
      toffle_palito_radio.prop('checked', false);

      toastr['error']('', 'Para agregar una base no debe de haber ingredientes añadidos', {
        closeButton: true,
        tapToDismiss: false,
      });
    }

    toastr['success']('', 'Base añadida correctamente', {
      closeButton: true,
      tapToDismiss: false,
    });
  }

  function addRow(type){

    var repeated = false;
    console.log(ids);
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
          console.log(ids);
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

          //Deshabilitar radio buttons
          waffle_radio.prop('disabled', true);
          half_waffle_radio.prop('disabled', true);
          quarter_waffle_radio.prop('disabled', true);
          bubble_radio.prop('disabled', true);
          toffle_palito_radio.prop('disabled', true);

          $("#items_table>tbody").append(content);
          feather.replace();
          calculate();

          toastr['success']('', 'Ingrediente agregado', {
            closeButton: true,
            tapToDismiss: false,
        });

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
      if(ids.length == 0)
      {
        //Quitar checked
        $('#waffle_radio').prop('checked', false);
        $('#half_waffle_radio').prop('checked', false);
        $('#quarter_waffle_radio').prop('checked', false);
        $('#bubble_radio').prop('checked', false);
        $('#toffle_palito_radio').prop('checked', false);

        //habilitar radio buttons
        $('#waffle_radio').prop('disabled', false);
        $('#half_waffle_radio').prop('disabled', false);
        $('#quarter_waffle_radio').prop('disabled', false);
        $('#bubble_radio').prop('disabled', false);
        $('#toffle_palito_radio').prop('disabled', false);
      }
      calculate();
  }

  function caculateCost() {
      value = $('#portion_dish').val();
      cost = $('#selected_ingredient option:selected').data("cost");
      gr = $('#selected_ingredient option:selected').data("gr");
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