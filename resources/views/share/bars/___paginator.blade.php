@if( isset($items) && isset($listItems) )
<div class="clearfix">
    <form method="get" action="{{route($listItems)}}" class="form-inline frmSearchInList float-right">
        {{--        @include('shared.ui_kit.___popup_roles')--}}
            <div class="mt-3">
                @if( isset($items->onEachSide) )
                    {{  $items->onEachSide(1)->links() }}
                @endif
            </div>
    </form>
</div>
@endif
