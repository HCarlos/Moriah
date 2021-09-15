
<table class="table text-dark-m2 text-95 bgc-white ml-n1px m-2" id="table">
    <thead class="text-dark-tp3 bgc-grey-l4 text-90 border-b-1 brc-transparent">
    <tr>
        <th>ID</th>
        <th>USERNAME</th>
        <th>NOMBRE COMPLETO</th>
        <th>CURP</th>
        <th>ROLES</th>
        <th></th>
    </tr>
    </thead>

    <tbody class="mt-1">
    @foreach($items as $item)
    <tr class="bgc-h-yellow-l4 d-style">

        <td class='text-blue-d1 text-600 text-95'>
            {{$item->id}}
        </td>
        <td class="text-600 ">
            {{$item->username}}
        </td>
        <td class="text-600 ">
            {{$item->FullName}}
        </td>
        <td class="text-600 ">
            {{$item->curp}}
        </td>
        <td >
            @foreach($item->roles as $rol)
                <span class="badge badge-sm text-white pb-1 px-25 radius-2" style="background-color: {{$rol->color}} !important;">{{$rol->name}}</span>
            @endforeach
        </td>

        <td>
            <!-- action buttons -->
            <div class='d-none d-lg-flex'>
                @include('share.bars.___editItem')
                @include('share.bars.___removeItem')
            </div>

            <!-- show a dropdown in mobile -->
            <div class='dropdown d-inline-block d-lg-none dd-backdrop dd-backdrop-none-lg'>
                <a href='#' class='btn btn-default btn-xs py-15 radius-round dropdown-toggle' data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                </a>

                <div class="dropdown-menu dd-slide-up dd-slide-none-lg">
                    <div class="dropdown-inner">
                        @include('share.bars.___editItem')
                        @include('share.bars.___removeItem')
                    </div>
                </div>
            </div>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>
