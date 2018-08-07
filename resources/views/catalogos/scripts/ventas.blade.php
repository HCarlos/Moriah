
@section('scripts_ventas')
    <script>
        jQuery(function($) {
            $(document).ready(function() {

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

            });
        });

    </script>
@endsection