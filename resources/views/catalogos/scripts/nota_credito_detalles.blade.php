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


                if($(".btnCloseVentaDetalleNormal")){
                    $(".btnCloseVentaDetalleNormal").on('click',function (event) {
                        event.preventDefault();
                        window.close()
                    });
                }
/*
                if ( $("#frmNewNotaCredito") ){
                    $("#frmNewNotaCredito").on("submit", function (event) {
                        event.preventDefault();
                        $("#prealoader").removeClass('hide');
                        var Data = $(this).serialize();
                        var Url = '/buscar_venta';
                        $(function () {
                            $.ajax({
                                cache: false,
                                type: 'put',
                                url: Url,
                                data:  Data,
                                dataType: 'json',
                                success: function(data) {
                                    if (data.mensaje == "OK"){
                                        var tbl = "";
                                        $.each( data.data, function( key, val ) {
                                            var sid = data.data[key].id+"_"+data.data[key].venta_id+"_"+data.data[key].producto_id+"_"+data.data[key].user_id;
                                            tbl += "<tr>";
                                            tbl += "<td>"+data.data[key].id+"</td>";
                                            tbl += "<td>"+data.data[key].cantidad+"</td>";
                                            tbl += "<td>"+data.data[key].descripcion+"</td>";
                                            tbl += "<td>"+data.data[key].pv+"</td>";
                                            tbl += "<td>"+data.data[key].importe+"</td>";
                                            tbl += "<td>"+data.data[key].iva+"</td>";
                                            tbl += "<td>"+data.data[key].total+"</td>";
                                            tbl += "<td><input type='number' id='"+sid+"' name='productos[]' value='0' min='0' max='"+data.data[key].cantidad+"' class='form-control col-xs-2' /></td>";
                                            tbl += "<td></td>";
                                            tbl += "</tr>";
                                        });
                                        $("#tblNC > tbody").append(tbl);
                                    }else{
                                        alert(data.mensaje);
                                    }
                                    $("#prealoader").addClass('hide');
                                }
                            });
                        });

                    });
                }

                if ( $("#btnVisualizarNC") ) {
                    $("#btnVisualizarNC").on('click',function (event) {
                        event.preventDefault();

                        $('input[name^="productos"]').each(function(e) {
                            //alert( $(this).attr('id') );
                        });

                    });
                }
*/

            });
        });

    </script>
@endsection