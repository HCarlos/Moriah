@section('scripts_compras')
    <script src="{{ asset('assets/js/jquery-2.0.3.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        // alert("Hola");
        jQuery(function($) {
            $(document).ready(function() {

                if ( $(".btnCompraDetalle") ){
                    $(".btnCompraDetalle").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');

                        var Url = event.currentTarget.id;

                        $(function () {
                        //     alert(Url);

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

                if($(".btnCloseCompraDetalle")){
                    $(".btnCloseCompraDetalle").on('click',function (event) {
                        event.preventDefault();
                        window.close()
                    });
                }


            });
        });

    </script>
@endsection