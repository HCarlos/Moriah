@section('scripts')
    {{--<scripts src="{{ asset('js/jquery-1.12.4.js') }}"></scripts>--}}
    <script src="{{ asset('assets/js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    <script>
        jQuery(function($) {
            $(document).ready(function() {

                $("#preloaderLocal").hide();
                $('#{{ $tableName}}').removeClass('hide');

                var nCols = $('#{{ $tableName}}').find("tbody > tr:first td").length;
                var aCol = [];

                for (i = 0; i < nCols - 1; i++) {aCol[i] = {};}
                aCol[nCols - 1] = {"sorting": false};

                var oTable = $('#{{ $tableName}}').dataTable({
                    "language": {
                        "lengthMenu": "_MENU_ registros por página",
                        "paginate": {
                            "first": "<<",
                            "last": ">>",
                            "previous": "<",
                            "next": ">"
                        },
                        "search": "Buscar en esta tabla",
                        "processing": "Procesando...",
                        "loadingRecords": "Cargando...",
                        "zeroRecords": "No hay registros",
                        "info": "_START_ - _END_ de _TOTAL_ registros",
                        "infoEmpty": "No existen datos",
                        "infoFiltered": ""
                    },
                    "sorting": [[0, "desc"]],
                    "columns": aCol,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "retrieve": true,
                    "destroy": false
                });

            });
        });
    </script>
@endsection