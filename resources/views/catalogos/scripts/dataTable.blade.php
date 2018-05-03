
@section('styles')
<link href="{{ asset('assets/css/jquery.dataTables.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"> </script>
<script src="{{ asset('js/jquery.dataTables.bootstrap.js') }}"> </script>
<script src="{{ asset('js/date-time/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/date-time/bootstrap-timepicker.min.js') }}"></script>
<script>
    jQuery(function($) {
        $(document).ready(function() {

            $("#preloaderLocal").hide();
            $('#{{ $tableName}}').removeClass('hide');

            var nCols = $('#{{ $tableName}}').find("tbody > tr:first td").length;
            var aCol = [];

            for (i = 0; i < nCols - 1; i++) {aCol[i] = {};}
            aCol[nCols - 1] = {"sorting": false};

            oTable = $('#{{ $tableName}}').dataTable({
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por página",
                    "oPaginate": {
                        "sPrevious": "&lsaquo;",
                        "sNext": "&rsaquo;"
                    },
                    "sSearch": "Buscar",
                    "sProcessing":"Procesando...",
                    "sLoadingRecords":"Cargando...",
                    "sZeroRecords": "No hay registros",
                    "sInfo": "_START_ - _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "No existen datos",
                    "sInfoFiltered": "(De _MAX_ registros)"
                },
                "aaSorting": [[ 0, "desc" ]],
                "aoColumns": aCol,
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "bRetrieve": true,
                "bDestroy": false
            });


        });
    });
</script>
@endsection