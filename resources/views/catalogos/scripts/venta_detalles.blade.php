@section('scripts_ventas')
    <script>
        jQuery(function($) {
            $(document).ready(function() {
                if ( $(".btnVentaDetalleNormal") ){
                    $(".btnVentaDetalleNormal").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-footer").hide();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');

                        var Url = event.currentTarget.id;
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
                }

                if ( $(".btnPagarVenta") ){
                    $(".btnPagarVenta").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');

                        var Url = event.currentTarget.id;
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
                }

                if($(".btnCloseVentaDetalleNormal")){
                    $(".btnCloseVentaDetalleNormal").on('click',function (event) {
                        event.preventDefault();
                        window.close()
                    });
                }

            });
        });

    </script>
@endsection