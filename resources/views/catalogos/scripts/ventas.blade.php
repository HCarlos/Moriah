
@section('scripts_ventas')
    <script>
        jQuery(function($) {
            $(document).ready(function() {
                
                $(".btnPrintListado").hide();
                $(".btnPrintListadoExcel").hide();

                var totalItems = @if ( isset( $items ) && $items->count() > 0 ) {{ $items->count() }} @else 0 @endif;
                
                if ( $(".btnPrintListado") && totalItems > 0){
                    $(".btnPrintListado").show();
                    $(".btnPrintListadoExcel").show();
                    
                }


                if ( $(".btnVentaPaquete") || $(".btnVentaPedido") || $(".btnVentaNormal") ){
                    $(".btnVentaPaquete, .btnVentaPedido, .btnVentaNormal").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-footer").hide();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');
                        var Url = event.currentTarget.id;
                        // alert(Url);
                        $(function () {
                            $.ajax({
                                method: "get",
                                url: Url
                            })
                                .done(function (response) {
                                    //alert(response);
                                    $("#myModal .modal-body").html(response);
                                });
                        });

                    });
                }

                if ( $(".btnBuscarVentaID") ){
                    $(".btnBuscarVentaID").on("click", function (event) {
                        event.preventDefault();
                        var ids =event.currentTarget.id.split('-');
                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-footer").hide();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');
                        $(function () {
                            $.ajax({method: "get", url: '/llamar_busqueda_individual_ajax/'+ids[1]})
                                .done(function (response) {
                                    $("#myModal .modal-body").html(response);
                                });
                        });
                    });
                }

                if ( $(".btnVentaDate") ){
                    $(".btnVentaDate").on("click", function (event) {
                        event.preventDefault();
                        var ids =event.currentTarget.id.split('-');
                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-footer").hide();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');
                        $(function () {
                            $.ajax({method: "get", url: '/llamar_venta_fecha_ajax'})
                                .done(function (response) {
                                    $("#myModal .modal-body").html(response);
                                });
                        });
                    });
                }

            });
        });

    </script>
@endsection