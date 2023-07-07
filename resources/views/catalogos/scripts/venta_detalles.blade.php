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
                        var Url = $(this).attr('id');
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
                }

                if ( $(".btnShowProperties") ){
                    $(".btnShowProperties").on("click", function (event) {
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

                if ( $("#frmSearchCode") ){
                    $("#codigo").val("");
                    $("#searchProducto").val("");
                    $("#cantidad").val(1);
                    $("#guardandoVenta").hide();
                    $("#frmSearchCode").on("submit", function (event) {
                        event.preventDefault();
                        $("#guardandoVenta").show();
                        var Data = $(this).serialize();
                        var Url = '/store_venta_detalle_normal_ajax';
                        $(function () {
                            $.ajax({
                                cache: false,
                                type: 'post',
                                url: Url,
                                data:  Data,
                                dataType: 'json',
                                success: function(data) {
                                    if (data.mensaje === "OK"){
                                        $("#searchProducto").empty();
                                        location.reload();
                                    }else{
                                        alert(data.mensaje);
                                    }
                                }
                            });
                        });

                    });
                }
            });
        });

    </script>
@endsection



@section('scripts_venta_detalles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        jQuery(function($) {
            $(document).ready(function() {

                if ( $("#searchProducto") ) {

                    src = "{{ route('buscarProducto') }}";
                    $("#searchProducto").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: src,
                                dataType: "json",
                                data: {
                                    search: request.term
                                },
                                success: function (data) {
                                    response(data);
                                },
                            });
                        },
                        minLength: 3,
                    });

                    $("#searchProducto").on("autocompleteselect", function (event, ui) {
                        var Id = ui.item['id'];
                        $.get("/getProducto/" + Id, function (data) {
                            $("#codigo").val(data.data.codigo);
                            $("#searchProducto").val(data.data.descripcion);
                            $("#cantidad").val(1);
                            $("#cantidad").focus();
                        }, "json");
                    });

                    $("#searchProducto").on("keyup", function (event) {
                        clearObjects();
                    });

                }

                function clearObjects() {
                    // $("#ubicacion_id").val(0);
                    $("#codigo").val("");
                    // $("#ubicacion_id_span").html(0);
                }

            });
        });

    </script>
@endsection