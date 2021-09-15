@if($editItem)
<a href="{{ is_null($editItem) ? '#' : route($editItem,["Id"=>$item->id] ) }}" class="editItem mx-2px btn radius-1 border-2 btn-xs btn-brc-tp btn-light-secondary btn-h-lighter-success btn-a-lighter-success">
    <i class="fa fa-pencil-alt"></i>
</a>
@endif
