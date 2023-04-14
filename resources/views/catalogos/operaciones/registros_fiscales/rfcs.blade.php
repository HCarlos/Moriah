@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
                        <span id="titulo_catalogo">
                            <i class="fa fa-user default"></i>
                            REGISTROS FISCALES
                        </span>
            <a id="/form_rfc_nuevo_ajax" class="btn btn-purple btn-minier icon-only marginLeft2em btnRFCNuevo" title="Agregar Producto" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus bigger-150"></i>
            </a>

        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($rfcs)
                    <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="rfc" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">RFC</th>
                            <th aria-label="razon_social" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Razón Social 4.0</th>
                            <th aria-label="razon_social" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Régimen Fiscal</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($rfcs as $rfc)
                            <tr>
                                <td>{{ $rfc->id }}</td>
                                <td>{{ $rfc->rfc }}</td>
                                <td>{{ $rfc->razon_social_cfdi_40 }}</td>
                                <td>{{ $rfc->Regimen_Fiscal->regimen_fiscal ?? 'Null' }}</td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            <a href="#" class="btn btn-link pull-right btnAction2" id ="RFC-{{$rfc->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-110 red" ></i>
                                            </a>
                                            <a  id="/form_rfc_editar_ajax/{{$rfc->id}}"  class="btn btn-link pull-right btnRFCEditar" title="Editar" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-pencil bigger-110 success"></i>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger" role="alert">No se encontraron datos</div>
                @endif

            </div>
        </div>
    </div>

@endsection

@include('catalogos.scripts.dataTable')

@include('catalogos.scripts.rfcs')
