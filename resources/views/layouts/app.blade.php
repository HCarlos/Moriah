<!DOCTYPE html>
<html lang="en">
    @include('partials.htmlheader')
<body class="no-skin">

    @include('partials.navbar')

    <div class="main-container ">

        @include('partials.sidebar')

        <div class="main-content">
            <div class="main-content-inner">
                @include('partials.breadcrumbs')

                <div class="page-content">
            	    @yield('main-content')
                </div>
                <!-- /page-content -->

            </div>
            <!-- /main-content-inner -->
        </div>
        <!-- /main-content -->

    </div>
    <!-- /main-container -->
    @include('partials.footer')
    @include('partials.modal')
    @include('partials.scripts')

</body>
</html>
