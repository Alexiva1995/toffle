<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
</script>

<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

<script src="{{ asset('vendors/js/jquery-confirm/jquery-confirm.min.js') }}"></script>

<script type="text/javascript">
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
              width: 14,
              height: 14
            });
        }

        @if(session('success'))  
            toastr['success']('{{ session('success') }}', '¡Exitoso!', {
                closeButton: true,
                tapToDismiss: false
            });
        @endif

        @if(session('danger'))
            toastr['error']('{{ session('danger') }}', 'Error', {
                closeButton: true,
                tapToDismiss: false
            });
        @endif

        @if(session('warning'))
            toastr['warning']('{{ session('warning') }}', 'Advertenecia', {
                closeButton: true,
                tapToDismiss: false
            });
        @endif

        @if(session('info'))
            toastr['info']('{{ session('info') }}', 'Informacion', {
                closeButton: true,
                tapToDismiss: false
            });
        @endif

        @if(isset($errors))
            @foreach ($errors->all() as $message)
                toastr['error']('{{ $message }}', 'Validación fallida', {
                    closeButton: true,
                    tapToDismiss: false
                });
            @endforeach
        @endif
    })
</script>


<script>
    function submitForms (btn_id, load_class, form_id) {
        $(btn_id).click( function() {
            var this_button = $(this);
            this_button.attr('disabled', 'disabled').addClass('disabled');
            $(load_class).addClass('spinner-border spinner-border-sm');
            $(form_id).submit();
        });
    }

    function deleteElement(id,  form_id, text_element, optional_text = null) {
        var text = '';

        if (optional_text != null) {
            text = '<strong class="text-danger">'+optional_text+'...</strong> <br/> <br/>'+'Estas seguro que quieres eliminar '+text_element+'?';
        }else{
            text = 'Estas seguro que quieres eliminar '+text_element+'?';
        }

        $.confirm({
            title: 'Confirmar!',
            content: text,
            columnClass: 'col-12 col-md-4 col-xs-4',
            containerFluid: true,
            buttons: {
                confirm: {
                    text: 'Eliminar',
                    btnClass: 'btn-danger',
                    action: function () {
                        $(this).addClass('disabled');
                        $(this).addClass('spinner-border spinner-border-sm');
                        $(form_id+id).submit();
                    }
                },
                cancelar: function () {
                },
            }
        });
    }
</script>

<script>

    function flatpickrRange(id, from, to) {
        $(id).flatpickr({
            mode:'range',
            ariaDateFormat:'Y-m-d',
            dateFormat:'Y-m-d',
            locale: {
                weekdays: {
                  shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                  longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
                }, 
                months: {
                  shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                  longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
                weekAbbreviation: "Sem",
                rangeSeparator: " a ",
                yearAriaLabel: "Año",
                monthAriaLabel: "Mes",
                hourAriaLabel: "Hora",
                minuteAriaLabel: "Minuto",
            },
            onChange:function(selectedDates){
                var _this=this;
                var dateArr=selectedDates.map(function(date){return _this.formatDate(date,'Y-m-d');});
                $(from).val(dateArr[0]);
                $(to).val(dateArr[1]);
            },
        });
    }

    function flatpickrWeek(id) {
        $(id).flatpickr({
            mode: "range",
            dateFormat: "W-Y",
            defaultDate: ["today"],
            locale: {
                weekdays: {
                  shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                  longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
                }, 
                months: {
                  shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                  longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
                weekAbbreviation: "Sem",
                rangeSeparator: " a ",
                yearAriaLabel: "Año",
                monthAriaLabel: "Mes",
                hourAriaLabel: "Hora",
                minuteAriaLabel: "Minuto",
            },
            // weekNumbers: true,
            "plugins": [new weekSelect({})],
            onChange: [function(selectedDates, dateStr, instance){

                const year = this.selectedDates[0]
                    ? this.currentYear
                    : null;

                const weekNumber = this.selectedDates[0]
                    ? this.config.getWeek(this.selectedDates[0])
                    : null;

                dataWeek = '';

                if (weekNumber > 10) {
                    dataWeek = year+'-W'+weekNumber;
                }else{
                    dataWeek = year+'-W0'+weekNumber;
                }
                $('#week').data('week', dataWeek)
                // console.log($('#range_week').val());
            }]
        });
    }

    function roundDecimal(num, dec) {
        var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
        return parseInt(num * exp, 10) / exp;
    }

</script>