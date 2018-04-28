<div class="dataTables_wrapper" role="grid">
    @if ($items)
        <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
            <thead>
            <tr role="row">
                <th aria-label="id" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                <th aria-label="username" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Username</th>
                <th aria-label="nombre_completo" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Nombre Completo</th>
                <th aria-label="email" style="width: 150px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Email</th>
                <th aria-label="admin" style="width: 20px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Admin</th>
                <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
            </tr>
            </thead>
            <tbody aria-relevant="all" aria-live="polite" role="alert">
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->nombre_completo }}</td>
                    <td>{{ $item->email }}</td>
                    @if($item->isAdmin())
                        <td class="text-center"><i class="fas fa-check-circle green"></i></td>
                    @else
                        <td> &nbsp; </td>
                    @endif
                    <td width="100">
                        @if ($user->hasAnyPermission(['eliminar_usuarios','all']))
                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="usuario-{{$item->id.'-'.$user->id.'-'.$id.'-'.$npage.'-'.$tpaginas}}-2-/destroy_usuario/" title="Eliminar">
                                <i class="fa fa-trash fa-lg red" ></i>
                            </a>
                        @endif
                        @if ($user->hasAnyPermission(['editar_usuarios','all']))
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