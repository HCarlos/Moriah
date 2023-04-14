
@section('scripts_ventas')
    <script>
        jQuery(function($) {
            $(document).ready(function() {
                if ( $(".btnRFC") || $(".btnRFCNuevo") || $(".btnRFCEditar") || $(".btnRFCAddRegimen") ){
                    $(".btnRFC, .btnRFCNuevo, .btnRFCEditar, .btnRFCAddRegimen").on("click", function (event) {
                        event.preventDefault();

                        $("#myModal .modal-body").empty();
                        $("#myModal .modal-footer").hide();
                        $("#myModal .modal-body").html('<div class="fa-2x"><i class="fa fa-cog fa-spin"></i> Cargado datos...</div>');
                        $("#myModal").modal('show');
                        var Url = event.currentTarget.id;
                        alert(Url);
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
            });
        });

    </script>
@endsection