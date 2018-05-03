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
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
<script src="{{ asset('js/base.js') }}"></script>
<script src="{{ asset('js/moriah.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() { init(); });
    function init() {
        $("#preloaderGlobal").hide();
        if ( $("#titulo_catalogo") ){
                    @if ( isset($titulo_catalogo) )
            var titulo = "{{ $titulo_catalogo}}";
            $("#titulo_catalogo").html(titulo);
            @endif
        }
        var H0 = document.body.clientHeight + 145;
        $(".sidebar").css('height',H0);

        // $(".main-container").css('height',H0-40);
        // $(".main-content").css('height',H0-40);
        // $(".main-content-inner").css('height',H0-40);

        // $(".footer").css('top',H0+250);
        // alert( $(".footer").css('top') );

    }
</script>
