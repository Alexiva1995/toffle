<script>

   function submit(){
     $('#form_add_dish').submit()
   }


  numRows = 0;
  
  var ids = [];

  function addRow(){

    var repeated = false;

    if ($("#selected_dish option:selected").val() == null || $("#selected_dish option:selected").val() == '' || $("#portion_dish").val() == null || $("#portion_dish").val() == '') {
        toastr['error']('', 'Debes seleccionar primero un ingrediente y la porcion, para luego añadirlo', {
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
            <td class="text-center">'+numRows+'</td>\
            <input type="hidden" name="ingredient_ids[]" class="form-control dish_ids" id="dish_ids_'+numRows+'" value="'+$("#selected_dish option:selected").val()+'" required>\
            <td><input type="text" name="ingredient[]" class="form-control dish" id="selected_dish_'+numRows+'" value="'+$("#selected_dish option:selected").text()+'" required readonly></td>\
            <td><input type="text" name="portion[]" class="form-control price" id="portion_'+numRows+'" value="'+$("#portion_dish").val()+'" readonly required></td>\
            <td><input type="text" name="price[]" class="form-control price" id="price_'+numRows+'" value="'+$('#selected_dish option:selected').attr("price")+'" readonly required></td>\
            <td class="text-center"><a href="javascript:;" onclick="deleteRow('+numRows+')" style="color: #512F26;"><b>Eliminar</b> <i style="color: #512F26;" data-feather="x-circle"></i> </a></td>\
            </tr>';
            $("#items_table>tbody").append(content);
            feather.replace();

            // linpia los inputs de precio

            $("#profit").empty();
            let percentage_profit = '<input type="number" id="percentage_profit" class="form-control requerid @error("percentage_profit") is-invalid @enderror" name="percentage_profit" id="percentage_profit" oninput="calculate('+numRows+')" required />\
            @error("percentage_profit")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror';
            $("#profit").append(percentage_profit);

            $("#cost").empty();
            let cost_price = '<input type="text" id="cost_price" class="form-control requerid @error("cost_price") is-invalid @enderror" name="cost_price" id="cost_price" required readonly/>\
            @error("cost_price")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror';
            $("#cost").append(cost_price);

            $("#suggested").empty();
            let suggested_price = '<input type="text" id="suggested_price" class="form-control requerid @error("suggested_price") is-invalid @enderror" name="suggested_price" id="suggested_price" required readonly />\
            @error("suggested_price")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror';
            $("#suggested").append(suggested_price);

            feather.replace();

        }else{
          toastr['error']('', 'Este ingrediente ya fue añadido', {
              closeButton: true,
              tapToDismiss: false,
          });
        }
    }
  }

  function calculate(row){

          var total = 0;

          for (var i = 1; i <= numRows; i++){
              total += parseFloat($("#price_"+i).val());
          }

          profit = $("#percentage_profit").val();
          cost = $("#cost_price").val(total);
          sugg = $("#suggested_price").val(total * profit);

      }

      function deleteRow(row){
          $("#row_"+row).remove();
          numRows--;
      }
</script>