
@section('scripts_productos')
    <script>
        jQuery(function($) {
            $(document).ready(function() {
                if ( $(".btnRefreshPedidos") ){
                    $(".btnRefreshPedidos").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Actualizando precios de pedidos...</div>');
                        $("#myModal").modal('show');
                        var Url = event.currentTarget.id;
                        $(function () {
                            $.ajax({
                                method: "get",
                                url: Url
                            })
                                .done(function (response) {
                                    $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-check-circle-o text-success"></i><span class="marginLeft1em">'+response.mensaje+'</span></div>');
                                });
                        });

                    });
                }
            });
        });

    </script>
@endsection