@component('components.panel')
@slot('titulo',"Propiedades de la Venta")
@slot('barra_menu')
@endslot
@slot('contenido')
    <div class="dataTables_wrapper" role="grid">
        <div class="profile-user-info profile-user-info-striped">

            <div class="profile-info-row">
                <div class="profile-info-name"> ID </div>

                <div class="profile-info-value">
                    <span >{{$venta->id}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Tipo Venta </div>

                <div class="profile-info-value">
                    <span>{{$venta->TipoVenta}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Cliente </div>

                <div class="profile-info-value">
                    <span>{{$venta->user->id.' '.$venta->user->FullName}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Importe </div>

                <div class="profile-info-value">
                    <span>{{ number_format($venta->total,2) }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Abonos </div>

                <div class="profile-info-value">
                    <span>{{ number_format($Abonos,2) }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Adeudo </div>

                <div class="profile-info-value">
                    <span>{{ number_format(($venta->total - $Abonos),2) }}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Estatus </div>

                <div class="profile-info-value">
                    <span>
                        @if( $venta->isPagado() )
                            <b class="text-success">Pagado</b>
                        @else
                            No Pagado
                        @endif
                    </span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Fecha </div>

                <div class="profile-info-value">
                    <i class="icon-map-marker light-orange bigger-110"></i>
                    <span>{{$fecha}}</span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> Vendedor </div>

                <div class="profile-info-value">
                    <span>{{$venta->vendedor->id.' '.$venta->vendedor->FullName}}</span>
                </div>
            </div>


        </div>
    </div>
@endslot
@endcomponent
