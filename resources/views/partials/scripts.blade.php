<!-- basic scripts -->
<script src="{{ asset('assets/js/jquery-2.0.3.min.js') }}"></script>

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('/js/jquery.mobile.custom.js') }}'>"+"<"+"/script>");
</script>

<script src="{{ asset('/js/bootstrap.js') }}"></script>
<script src="{{ asset('/js/ace/ace.js') }}"></script>
<script src="{{ asset('/js/ace/ace.ajax-content.js') }}"></script>
<script src="{{ asset('/js/ace/ace.touch-drag.js') }}"></script>
<script src="{{ asset('/js/ace/ace.sidebar.js') }}"></script>
<script src="{{ asset('/js/ace/ace.sidebar-scroll-1.js') }}"></script>
<script src="{{ asset('/js/ace/ace.submenu-hover.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"> </script>
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
@yield('scripts_ventas')
@yield('scripts_compras')
@yield('scripts_productos')

<script src="{{ asset('js/base.js?timestamp()') }}"></script>
<script src="{{ asset('js/moriah.js?timestamp()') }}"></script>
<script type="text/javascript">

$(document).ready(function() {

    $("#preloaderGlobal").hide();

    if  ( $("#titulo_catalogo") ){
        @if ( isset($titulo_catalogo) )
            var titulo = "{{ $titulo_catalogo}}";
            $("#titulo_catalogo").html(titulo);
        @endif
    }

    var H0 = document.body.clientHeight -100;
    $(".sidebar").css('height',H0);

    $(".nav-list li").removeClass("active");
    if ($('.open').length === null) {
        $(this).addClass("active open");
    }

    // $('[data-rel=tooltip]').tooltip();
    // $('[data-rel=popover]').popover(
    //     {html:true, show:true}
    //     ).click(function(){
    //         $(this).popover('show');
    // })


});

</script>
@yield('scripts_venta_detalles')
