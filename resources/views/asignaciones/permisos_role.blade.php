@extends('layouts.app')

@section('main-content')
<div class="panel panel-moriah  " id="frmEdit0" style="height: 600px; ">
    <div class="panel-heading">
            <span>{{ $titulo }}</span>
    </div>
    @php
        $xTit = explode(' ',$titlePanels)
    @endphp
    <div class="panel-body panel-fill">

        <div class="row panel-fill">
            <div class="col-xs-6 col-sm-4 panel-fill">
                <div class="panel panel-primary panel-fill">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $xTit[0]  }}</h3>
                    </div>
                    {{ Form::select('listEle', $listEle, '', ['id' => 'listEle','multiple' => 'multiple','class'=>' listEle form-control  panel-fill']) }}
                </div>
            </div>

            <div class="col-xs-6 col-sm-4  panel-fill  vertical-center">
                <div class="panel panel-fill  jumbotron vertical-center">
                    <div class="panel-body panel-fill ">
                        @if ($user->hasAnyPermission(['asignar','sysop','all']))
                            <a class="btn btn-primary btn-block btnAsign0" id="{{ 'btnAsign0-'.$id.'-'.$iduser }}" href="#" role="button">Asignar <i class="glyphicon glyphicon-chevron-right"></i></a><br/><br/>
                        @endif
                        @if ($user->hasAnyPermission(['asignar','sysop','all']))
                            <a class="btn btn-primary btn-block btnUnasign0" id="{{ 'btnUnasign0-'.$id.'-'.$iduser }}" href="#" role="button"><i class="glyphicon glyphicon-chevron-left"></i> Quitar</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4  panel-fill-86">
                <div class="panel panel-primary panel-fill">
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

