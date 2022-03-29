
<section id="basic-datatable">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2">
                                <h2>Egresos <i data-feather="trending-down"
                                class="text-danger font-medium-1"></i></h2>
                                <div class="table-responsive">
                                    <table class="table rounded border-table border-primary" id="table2">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Id</th>
                                                <th class="text-center">egreso</th>
                                                <th class="text-center">Fecha</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($discharge as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="fw-bolder text-danger text-center">-{{ $item->expense }}$</td>
                                                <td class="text-center">{{ date('d-m-Y', strtotime($item->date)) }}</td>

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
        </div>
    </div>
</section>

@section('custom-js')

@include('panels.datatable.scripts')

<script>
    $(document).ready(function () {

    // $('#table2').dataTable();

    // Setup - add a text input to each footer cell
    $('#table2 thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#table2 thead');
 
    var table2 = $('#table2').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell2 = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title2 = $(cell2).text();
                    $(cell2).html('<input type="text" class="form-control" placeholder="' + title2 + '" />');

 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr2 = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition2 = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr2.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition2, cursorPosition2);
                        });
                });
        },
    });
});
</script>

@endsection
