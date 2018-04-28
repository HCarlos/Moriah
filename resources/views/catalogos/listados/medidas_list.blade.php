<div class="dataTables_wrapper" role="grid">
    @if ($items)
        <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
            <thead>
            <tr role="row">
                <th aria-label="id" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                <th aria-label="idmid" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting" >IdMig</th>
                <th aria-label="codigo" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Código</th>
                <th aria-label="Descripcion" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                <th aria-label="tipo" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting">Tipo</th>
                <th aria-label="" style="width: 200px;" colspan="1" rowspan="1" role="columnheader" tabindex="5" class="sorting_disabled"></th>
            </tr>
            </thead>
            <tbody aria-relevant="all" aria-live="polite" role="alert">
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->idmig }}</td>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ trim($item->lenguaje) }}</td>
                    <td>{{ trim($item->tipo)=='L'?'Lengüaje':'Pais' }}</td>
                    <td width="100">
                        @if ($user->hasAnyPermission(['eliminar_registro','all']))
                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="editorial-{{$item->id.'-'.$user->id.'-'.$id.'-'.$npage.'-'.$tpaginas}}-2-/destroy_clp/" title="Eliminar">
                                <i class="fa fa-trash fa-lg red" ></i>
                            </a>
                        @endif
                        @if ($user->hasAnyPermission(['editar_registro','all']))
                            <a href="{{ route('catalogos/', array('id' => $id,'idItem' => $item->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" target="_blank" title="Editar">
                                <i class="fas fa-pencil-alt blue"></i>
                            </a>
                        @endif

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-danger" role="alert">No se encontraron datos</div>
    @endif
</div>