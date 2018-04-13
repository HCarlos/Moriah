
$(document).ready(function() {

    var pathAssign   = ['/asign_role_user/','/asign_permission_role/'];
    var pathUnAssign = ['/unasign_role_user/','/unasign_permission_role/'];

    $("#preloaderGlobal").hide();
    if ( $(".btnAction2") ){
        $('.btnAction2').on('click', function(event) {
            event.preventDefault();
            //alert(event.currentTarget.id);
            var aID = event.currentTarget.id.split('-');
            var x = confirm("Desea eliminar el registro: "+aID[1]);
            if (!x){
                return false;
            }
            // alert(aID.length);
            //editorial-44-2-0-1-1-2-/destroy_editorial/
            if (aID.length == 7){
                var Url = aID[6]+aID[1]+"/"+aID[2]+"/"+aID[3]+"/"+aID[4];
            }else if(aID.length == 8){
                var Url = aID[7]+aID[1]+"/"+aID[3]+"/"+aID[6];
            }else{
                var Url = aID[5]+aID[1]+"/"+aID[3]+"/"+aID[6];
            }
            // alert(Url);
            $(function() {
                $.ajax({
                    method: "GET",
                    url: Url
                })
                    .done(function( response ) {
                        if (response.data == 'OK'){
                            if (aID.length == 7){
                                window.location.href = '/index/'+aID[3]+'/'+aID[4]+'/'+aID[5];
                            }else if(aID.length == 8){
                                window.location.href = '/index/'+aID[3]+'/'+aID[4]+'/'+aID[5];
                            }else{
                                window.location.href = '/index/'+aID[3]+'/'+aID[4]+'/'+aID[5];
                            }
                        }else{
                            alert(response.mensaje);
                        }
                    })
            });
        });
    }

    // if ( $("#btnPrueba") ){
    //     $("#btnPrueba").on('click', function(event) {
    //         event.preventDefault();
    //         var Data = {'id':1};
    //         $(function() {
    //             $.ajax({
    //                 method: "GET",
    //                 url: "/catajax/"+1,
    //                 data: Data
    //             })
    //                 .done(function( response ) {
    //                     var dat = response.data[5];
    //                     alert(dat.titulo);
    //                     var datt = response.dataTable.original.data[5];
    //                     alert(datt.titulo);
    //                 });
    //         });
    //     });
    // }

    if ( $(".listTarget") ){
        $(".listTarget").on('change', function(event) {
            event.preventDefault();
            var IdArr  = this.id.split('-');
            var Ida    = IdArr[1];
            var IdUser = $(this).val();
            window.location.href = '/list_left_config/'+Ida+'/'+IdUser+'/';
        });
    }

    if ( $(".btnAsign0") ){
        $(".btnAsign0").on('click', function(event) {
            event.preventDefault();
            var IdArr  = this.id.split('-');
            var Cat_Id = IdArr[1];
            var IdUser = IdArr[2];
            var x = $('.listEle option:selected').val();
            var y = $('select[name="listTarget"] option:selected').val();
            if (isUndefined(x)){
                alert("Seleccione una opción disponible");
                return false;
            }else{
                x='';
                $(".listEle option:selected").each(function () {
                    x += $(this).val() + "|";
                });

            }
            if (isUndefined(y) || y <= 0){
                alert("Seleccione un elemento");
                return false;
            }
            var Url = pathAssign[Cat_Id]+y+'/'+x+'/'+Cat_Id;


            $(function() {
                $.ajax({
                    method: "GET",
                    url: Url
                })
                    .done(function( response ) {
                        window.location.href = '/list_left_config/'+Cat_Id+'/'+y;
                    });
            });

        });
    }

    if ( $(".btnUnasign0") ){
        $(".btnUnasign0").on('click', function(event) {
            event.preventDefault();
            var IdArr  = this.id.split('-');
            var Cat_Id = IdArr[1];
            var z = $('.lstAsigns option:selected').val();
            var y = $('select[name="listTarget"] option:selected').val();
            if (isUndefined(z)){
                alert("Seleccione una opción disponible");
                return false;
            }else{
                z='';
                $(".lstAsigns option:selected").each(function () {
                    z += $(this).val() + "|";
                });
            }
            if (isUndefined(y) || y <= 0){
                alert("Seleccione un elemento");
                return false;
            }
            var Url = pathUnAssign[Cat_Id]+y+'/'+z+'/'+Cat_Id;
            $(function() {
                $.ajax({
                    method: "GET",
                    url: Url
                })
                    .done(function( response ) {
                        window.location.href = '/list_left_config/'+Cat_Id+'/'+y;
                    });
            });

        });
    }


    if ( $(".apartame") ){
        $(".apartame").on('click', function(event) {
            event.preventDefault();
            var IdArr  = this.id.split('-');
            var Ida    = IdArr[1];
            var Url = '/apartame/'+IdArr[1]+'/'+IdArr[2];
            // alert(Url);
            $(function() {
                $.ajax({
                    method: "GET",
                    url: Url
                })
                    .done(function( response ) {
                        alert(response.mensaje);
                        window.location.reload();
                    });
            });
        });
    }

});