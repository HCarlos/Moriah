@extends('home')

@section('content_form_permisions')
<div class="panel panel-primary  panel-fill" id="frmEdit0">
    <div class="panel-heading">
            <span>{{ $titulo }}</span>
    </div>
    @php
        $xTit = explode(' ',$titlePanels)
    @endphp

    <div class="panel-body panel-fill">

        <div class="row panel-fill">
            <div class="col-xs-6 col-sm-4 panel-fill">
                <div class="panel panel-success panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $xTit[0]  }}</h3>
                    </div>
                    {{ Form::select('listEle', $listEle, '', ['id' => 'listEle','multiple' => 'multiple','class'=>' listEle form-control  panel-fill']) }}
                </div>
            </div>

            <div class="col-xs-6 col-sm-4  panel-fill  vertical-center">
                <div class="panel panel-fill  jumbotron vertical-center">
                    <div class="panel-body panel-fill ">
                        @if ($user->hasAnyPermission(['asignar_roles_usuario','all']))
                            <a class="btn btn-default btnAsign0 form-control" id="{{ 'btnAsign0-'.$id.'-'.$iduser }}" href="#" role="button">Asignar <i class="fas fa-angle-right"></i></a><br/><br/>
                        @endif
                        @if ($user->hasAnyPermission(['eliminar_roles_usuario','all']))
                            <a class="btn btn-default btnUnasign0 form-control" id="{{ 'btnUnasign0-'.$id.'-'.$iduser }}" href="#" role="button"><i class="fas fa-angle-left"></i> Quitar</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4  panel-fill-86">
                <div class="panel panel-success panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $xTit[1]  }}</h3>
                    </div>
                    {{ Form::select('listTarget', $listTarget, $iduser, ['id' => 'listTarget-'.$id,'size' => '1', 'class'=>'listTarget form-control']) }}
                    {{ Form::select('lstAsigns', $lstAsigns, '', ['id' => 'lstAsigns','multiple' => 'multiple', 'class'=>'lstAsigns form-control panel-fill']) }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

