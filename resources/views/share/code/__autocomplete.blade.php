<script >

    jQuery(function($) {
        $(document).ready(function() {

            var getParents = "/getItemParent/";

            var Objs = ["#search_localidad","#search_ciudad","#search_colonia","#search_calle","#search_localidad_calle","#search_ubicacion","#search_rfc","#search_persona","#search_pariente","#search_vehiculo","#search_contrato","#search_productor","#search_municipio"];
            var Urls = ["{{ route("searchLocalidad") }}","{{ route("searchCiudad") }}","{{ route("searchColonia") }}","{{ route("searchCalle") }}","{{ route("searchCalleLocalidad") }}","{{ route("searchUbicacion") }}","{{ route("searchRFC") }}","{{ route("searchPersona") }}","{{ route("searchPariente") }}","{{ route("searchPersonaVehiculo") }}","{{ route("searchContrato") }}","{{ route("searchPersona")}}","{{ route("searchMunicipio")}}"];
            var Gets = ["/getLocalidad/","/getCiudad/",'/getColonia/','/getCalle/','/getCalleLocalidad/','/getUbicacion/','/getRFC/','/getPersona/','/getPariente/','/getPersonaVehiculo/','/getContrato/','/getPersona/','/getMunicipio/'];
            var Ids =  ["id","id",'id','id','id/localidad_id','id','id','id','id','id','id','id','id'];

            for (i=0;i<13;i++)
                if ( $(Objs[i]) ) callAjax($(Objs[i]), Urls[i], Gets[i], i, Ids[i]);

            function callAjax(Obj, Url, Get, Item, ID) {
                $(Obj).autocomplete({
                    source: function(request, response) {
                        // var ta = $("#tipo_asentamiento") ? $("#tipo_asentamiento").val() : "";
                        $.ajax({
                            url: Url,
                            dataType: "json",
                            data: {
                                search  : request.term,
                                tasento : $("#tipo_asentamiento") ? $("#tipo_asentamiento").val() : ""
                            },
                            success: function(data) {
                                response(data);
                            },
                        });
                    },
                    minLength: 3,
                });

                $( Obj ).on( "autocompleteselect", function( event, ui ) {
                    var ox = ID.split('/');
                    var Id;
                    if ( ox.length ==1 ) Id = ui.item[ID];
                    if ( ox.length == 2 ) Id = ui.item[ox[0]]+"/"+ui.item[ox[1]];
                    $.get( Get+Id, function( data ) {
                        asignObjects(Obj,Item, data);
                    }, "json" );
                });

                $( Obj ).on( "keyup", function( event ) {
                    clearObjects(Item);
                });

            }

            function asignObjects(Obj, Item, data) {
                // alert(Item);
                //
                switch (Item) {
                    case 0:
                        if ( $("#localidad_id") )     $("#localidad_id").val(data.data[0].id);
                        if ( $("#municipio_id_1") )   $("#municipio_id_1").val(data.data[0].municipio_id);
                        if ( $("#municipio") )        $("#municipio").val(data.data[0].municipio);
                        if ( $("#estado_id") )        $("#estado_id").val(data.data[0].estado_id);
                        if ( $("#estado") )           $("#estado").val(data.data[0].estado);
                        if ( $("#cp") )               $("#cp").val(data.data[0].codigo_postal);Obj.val(data.data[0].localidad);
                        break;
                    case 1:
                        if ( $("#ciudad_id") )        $("#ciudad_id").val(data.data[0].id);
                        if ( $("#municipio_id_2") )   $("#municipio_id_2").val(data.data[0].municipio_id);
                        Obj.val(data.data[0].ciudad);
                        break;
                    case 2:
                        // $("#colonia_id").val(data.data[0].id);
                        if ( $("#localidad_calle_id") )     $("#localidad_calle_id").val(data.data[0].id);
                        if ( $("#colonia_id") )       $("#colonia_id").val(data.data[0].localidad_id);
                        if ( $("#search_colonia") )   $("#search_colonia").val(data.data[0].localidad);
                        if ( $("#search_localidad") )   $("#search_localidad").val(data.data[0].localidad);
                        if ( $("#municipio_id_1") )   $("#municipio_id_1").val(data.data[0].municipio_id);
                        if ( $("#municipio") )        $("#municipio").val(data.data[0].municipio);
                        if ( $("#estado_id") )        $("#estado_id").val(data.data[0].estado_id);
                        if ( $("#estado") )           $("#estado").val(data.data[0].estado);
                        Obj.val(data.data[0].colonia);
                        break;
                    case 3:
                        console.log("calle");

                        if ( $("#calle_id") )         $("#calle_id").val(data.data[0].id);
                        if ( $("#search_calle") )   $("#search_calle").val(data.data[0].calle);
                        if ( $("#cp") )               $("#cp").val(data.data[0].codigo_postal);



                        if ( $("#colonia_id") )       $("#colonia_id").val(data.data[0].localidad_id);
                        if ( $("#search_colonia") )   $("#search_colonia").val(data.data[0].localidad);

                        if ( $("#localidad_id") )       $("#localidad_id").val(data.data[0].localidad_id);
                        if ( $("#search_localidad") )   $("#search_localidad").val(data.data[0].localidad);


                        if ( $("#municipio_id_1") )   $("#municipio_id_1").val(data.data[0].municipio_id);
                        if ( $("#municipio") )        $("#municipio").val(data.data[0].municipio);
                        if ( $("#estado_id") )        $("#estado_id").val(data.data[0].estado_id);
                        if ( $("#estado") )           $("#estado").val(data.data[0].estado);


                        // if ( $("#asentamiento") )     $("#asentamiento").val(data.data[0].tipo_asentamiento+' '+data.data[0].localidad);
                        // if ( $("#localidad_id") )     $("#localidad_id").val(data.data[0].localidad_id);
                        Obj.val(data.data[0].calle);
                        break;
                    case 4:
                        console.log("localidad");
                        // if ( $("#calle_id") )         $("#calle_id").val(data.data[0].id);
                        if ( $("#localidad_id") )     $("#localidad_id").val(data.data[0].localidad_id);
                        if ( $("#asentamiento") )     $("#asentamiento").val(data.data[0].tipo_asentamiento+' '+data.data[0].localidad);
                        Obj.val(data.data[0].calle);
                        break;
                    case 5:
                        console.log("ubicacion");
                        if ( $("#ubicacion_id") )     $("#ubicacion_id").val(data.data[0].id);
                        Obj.val(data.data[0].ubicacion);
                        break;
                    case 6:
                        console.log("rfc");
                        if ( $("#rfc_id") )     $("#rfc_id").val(data.data[0].id);
                        Obj.val(data.data[0].rfc);
                        break;
                    case 7:
                        console.log("persona");
                        if ( $("#persona_id") )     $("#persona_id").val(data.data[0].id);
                        Obj.val(data.data[0].persona);
                        break;
                    case 8:
                        console.log("pariente");
                        if ( $("#pariente_id") )     $("#pariente_id").val(data.data[0].id);
                        Obj.val(data.data[0].pariente);
                        getParentesco(getParents + data.data[0].id);
                        break;
                    case 9:
                        console.log("vehiculo");
                        if ( $("#vehiculo_id") )     $("#vehiculo_id").val(data.data[0].id);
                        Obj.val(data.data[0].vehiculo);
                        break;
                    case 10:
                        console.log("contrato");
                        if ( $("#contrato_id") )     $("#contrato_id").val(data.data[0].id);
                        Obj.val(data.data[0].contrato);
                        break;
                    case 11:
                        console.log("rancho");
                        if ( $("#productor_id") )     $("#productor_id").val(data.data[0].id);
                        Obj.val(data.data[0].persona);
                        break;
                    case 12:
                        console.log("rancho");
                        if ( $("#municipio_id") )     $("#municipio_id").val(data.data[0].id);
                        Obj.val(data.data[0].municipio);
                        break;
                }
            }

            function clearObjects(Item) {
                switch (Item) {
                    case 0:
                        $("#ubicacion_id").val(0);
                        break;
                    case 1:
                        $("#ciudad_id").val(0);
                        break;
                    case 2:
                        $("#colonia_id").val(0);
                        break;
                    case 3:
                        $("#calle_id").val(0);
                        break;
                    case 4:
                        $("#localidad_id").val(0);
                        break;
                    case 5:
                        $("#ubicacion_id").val(0);
                        break;
                    case 6:
                        $("#rfc_id").val(0);
                        break;
                    case 7:
                        $("#persona_id").val(0);
                        break;
                    case 8:
                        $("#pariente_id").val(0);
                        $("#parentesco2").empty();
                        break;
                    case 9:
                        $("#vehiculo_id").val(0);
                        break;
                    case 10:
                        $("#contrato_id").val(0);
                        break;
                    case 11:
                        $("#productor_id").val(0);
                        break;
                    case 12:
                        $("#municipio_id").val(0);
                        break;
                }
            }

            function clearObjAll(){
                if ( $("#ubicacion_id") )     $("#ubicacion_id").val(0);
                if ( $("#estado_id") )        $("#estado_id").val(0);
                if ( $("#municipio_id_1") )   $("#municipio_id_1").val(0);
                if ( $("#municipio_id_2") )   $("#municipio_id_2").val(0);
                if ( $("#ciudad_id") )        $("#ciudad_id").val(0);
                if ( $("#colonia_id") )       $("#colonia_id").val(0);
                if ( $("#calle_id") )         $("#calle_id").val(0);
                if ( $("#codigo_postal_id") ) $("#codigo_postal_id").val(0);
                if ( $("#search_colonia") )   $("#search_colonia").val("");
                if ( $("#search_localidad") ) $("#search_localidad").val("");
                if ( $("#search_ciudad") )    $("#search_ciudad").val("");
                if ( $("#estado") )           $("#estado").val("");
                if ( $("#municipio") )        $("#municipio").val("");
                if ( $("#calle") )            $("#calle").val("");
                if ( $("#cp") )               $("#cp").val("");
                if ( $("#num_ext") )          $("#num_ext").val("");
                if ( $("#num_int") )          $("#num_int").val("");
                if ( $("#asentamiento") )     $("#asentamiento").val("");
                if ( $("#search_ubicacion") ) $("#search_ubicacion").val("");
                if ( $("#search_rfc") )       $("#search_rfc").val("");
                if ( $("#search_persona") )   $("#search_persona").val("");
                if ( $("#search_pariente") )  $("#search_pariente").val("");
                if ( $("#parentesco2") )      $("#parentesco2").empty();
                if ( $("#search_vehiculo") )  $("#search_vehiculo").val("");
                if ( $("#search_contrato") )  $("#search_contrato").val("");
                if ( $("#search_productor") ) $("#search_productor").val("");
                if ( $("#search_municipio") ) $("#search_municipio").val("");
            }


            $("#tipo_asentamiento").on("change", function (event) {
                event.preventDefault();
                // clearObjAll();
                $('#search_colonia').trigger("keydown");
            });

            function getParentesco(Url){
                $.ajax({
                    method: "GET",
                    url: Url
                })
                    .done(function( response ) {
                        if (response.mensaje == 'OK') {
                            $.each(response.data, function( index, value ) {
                                $("#parentesco2").append("<option value='"+value+"'>"+value+"</option>");
                            });
                        }
                    })

            }



        });
    });

</script>

