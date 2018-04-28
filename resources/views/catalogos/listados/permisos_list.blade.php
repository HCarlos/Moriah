<div class="dataTables_wrapper" role="grid">
    @if ($items)
        <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
            <thead>
            <tr role="row">
                <th aria-label="id" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                <th aria-label="name" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Permiso</th>
                <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
            </tr>
            </thead>
            <tbody aria-relevant="all" aria-live="polite" role="alert">
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td width="100">
                        @if ($user->hasAnyPermission(['eliminar_permisos','all']))
                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="role-{{$item->id.'-'.$item->id.'-'.$id.'-'.$npage.'-'.$tpaginas}}-2-/destroy_permission/" title="Eliminar">
                                {{--<a href="{{ route('roleDestroy/', array('id' => $item->id,'idItem' => $item->id,'action' => 2)) }}" class="btn btn-link btn-xs pull-right" title="Eliminar">--}}
                                <i class="fa fa-trash fa-lg red" ></i>
                            </a>
                        @endif
                        @if ($user->hasAnyPermission(['editar_permisos','all']))
                            <a href="{{ route('catalogos/', array('id' => $id,'idItem' => $item->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">
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
