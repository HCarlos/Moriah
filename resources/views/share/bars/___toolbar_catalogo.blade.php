<div class="btn-group ms-2 mt-1">
    @if( ! is_null($newItem))
        <a href="{{ route($newItem) }}" class="btn btn-white btn-lighter-white btn-h-red btn-a-info">
            <i class="fa fa-plus w-3"></i>
        </a>
    @endif
    @if( ! is_null($searchButton))
        <a href="{{ route($searchButton) }}" class="btn btn-white btn-lighter-white btn-h-red btn-a-info btnFullModal"  data-toggle="modal" data-target="#modalFull">
            <i class="fa fa-search w-3"></i>
        </a>
    @endif
    @if( ! is_null($excelButton))
        <a href="{{ route($excelButton) }}" class="btn btn-white btn-lighter-white btn-h-red btn-a-info">
            <i class="fa fa-file-excel w-3"></i>
        </a>
    @endif
    @if( ! is_null($listItems))
        <form method="get" action="{{route($listItems)}}" class="form-inline frmSearchInList float-right"  data-toggle="tooltip" title="Buscar...">
            <div class="col-auto mr-auto">
                <div class="app-search">
                    <div class="input-group">
                        <input type="search" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar...">
                        <span class="mdi mdi-magnify"></span>
                        <div class="input-group-append">
                            <button class="btn btn-sm searchbrownamlobtn" type="submit">
                                <i class="fab fa-searchengin text-white fa-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif




</div>
