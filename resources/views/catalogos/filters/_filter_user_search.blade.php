<form method="get" action="{{ url('index_usuario/1/0') }}" class="form-inline">
    <div class="form-group">
        <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Buscar...">
    </div>
    <button type="submit" class="btn btn-sm btn-default"><span class="fa fa-search"></span></button>
    @include('catalogos.listados.paginate_list')
</form>
