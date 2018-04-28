    @role('administrator|system_operator')
        <div class="list-group todoloAncho" id="dvConfig0">
            <a class="button list-group-item form-control" href="{{ route('asignItem/', ['ida' => 0,'iduser' => 0]) }}">Asignar Roles a Usuario</a>
            <a class="button list-group-item form-control" href="{{ route('asignItem/', ['ida' => 1,'iduser' => 0]) }}">Asignar Permisos a Role</a>
        </div>
    @endrole
