<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>Registros Fiscales (Nuevo) </strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmRFCNuevo" action="{{}}">

        <div class="row panel-fill">
            <div class="col-xs-6 col-sm-4 panel-fill">
                <div class="panel panel-primary panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $xTit[0]  }}</h3>
                    </div>
                    {{ Form::select('rfcs', $rfcs, null, ['id' => 'rfcs','multiple' => 'multiple','class'=>' listEle form-control  panel-fill']) }}
                </div>
            </div>

            <div class="col-xs-6 col-sm-4  panel-fill  vertical-center">
                <div class="panel panel-fill  jumbotron vertical-center">
                    <div class="panel-body panel-fill ">
                        @if ($user->hasAnyPermission(['asignar','desasignar','all']))
                            <a class="btn btn-primary btn-block btnAsign0" id="{{ 'btnAsign0-'.$user_id }}" href="#" role="button">Asignar <i class="glyphicon glyphicon-chevron-right"></i></a><br/><br/>
                        @endif
                        @if ($user->hasAnyPermission(['asignar','desasignar','all']))
                            <a class="btn btn-primary btn-block btnUnasign0" id="{{ 'btnUnasign0-'.$user_idid }}" href="#" role="button"><i class="glyphicon glyphicon-chevron-left"></i> Quitar</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4  panel-fill-86">
                <div class="panel panel-primary panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $xTit[1]  }}</h3>
                    </div>
                    {{ Form::select('user_id', $usuario, null, ['id' => 'listTarget-'.$user_id,'size' => '1', 'class'=>'listTarget form-control']) }}
                    {{ Form::select('rfcs', $rfcs_asignados, '', ['id' => 'lstAsigns','multiple' => 'multiple', 'class'=>'lstAsigns form-control panel-fill']) }}
                </div>
            </div>
        </div>

        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";

    /*

    if ( $("#frmRFCEditar") ) {

        $("#frmRFCEditar").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmRFCEditar").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('RFC modificado con éxito');
                        $("#myModal").modal( 'hide' );
                        window.location.reload();
                    }else{
                        alert(data.mensaje);
                    }
                }
            });

        });
    }
*/

</script>

