
@section('scripts_productos')
    <script>
        jQuery(function($) {
            $(document).ready(function() {
                if ( $(".btnRefreshPaquetes") ){
                    $(".btnRefreshPaquetes").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Actualizando precios de paquetes...</div>');
                        $("#myModal").modal('show');
                        var Url = event.currentTarget.id;
                        // alert(Url);
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