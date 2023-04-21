
@section('styles')
<link href="{{ asset('assets/css/jquery.dataTables.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"> </script>
<script>
    jQuery(function($) {
        $(document).ready(function() {

            $("#preloaderLocal").hide();
            var nombreTabla = "{{ $tableName }}";
            $('#{{ $tableName }}').removeClass('hide');

            var nCols = $('#{{ $tableName }}').find("tbody > tr:first td").length;
            if (nCols === 0){
                nCols = $('#{{ $tableName }}').find("thead > tr:first th").length;
            }
            var aCol = [];

            for (i = 0; i < nCols - 1; i++) {aCol[i] = {};}
            aCol[nCols - 1] = {"sorting": false};

            var arrColGroup1 = [10, 25, 50, -1];
            var arrColGroup2 = [10, 25, 50, "Todos"];

            if (nombreTabla == "paquete_detalles" || nombreTabla == "registrosFiscalesTable"){
                arrColGroup1 = [-1, 10, 25, 50];
                arrColGroup2 = ["Todos", 10, 25, 50];
            }


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
                "aLengthMenu": [arrColGroup1, arrColGroup2],
                "bRetrieve": true,
                "bDestroy": false
            });


            $('.btnAction1').on('click', function(event) {
                event.preventDefault();
                $("#myModal .modal-body").empty();
                $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                $("#myModal").modal('show');

                var aID = event.currentTarget.id.split('-');
                var Url = aID[0] + aID[1] + "/" + aID[2];
                // alert(Url);
                $(function () {
                    $.ajax({
                        method: "get",
                        url: Url
                    })
                        .done(function (response) {
                            $("#myModal .modal-body").html(response);
                        });
                });

            });


            // if ( $(".btnCompraDetalle") ){
            //     $(".btnCompraDetalle").on("click", function (event) {
            //         event.preventDefault();
            //
            //         $("#myModal .modal-body").empty();
            //         $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
            //         $("#myModal").modal('show');
            //         var Url = event.currentTarget.id;
            //
            //         $(function () {
            //
            //         $.ajax({
            //             method: "get",
            //             url: Url
            //         })
            //             .done(function (response) {
            //                 $("#myModal .modal-body").html(response);
            //             });
            //
            //         });
            //
            //     });
            // }



        });
    });

</script>
@endsection