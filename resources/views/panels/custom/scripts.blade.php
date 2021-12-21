<script>
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
</script>

<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>

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
</script>