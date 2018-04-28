@extends('auth.auth')

@section('content')
<div id="forgot-box" class="forgot-box widget-box no-border visible">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="ace-icon fa fa-key"></i>
                Retrieve Password
            </h4>

            <div class="space-6"></div>
            <p>
                Enter your email and to receive instructions
            </p>

            <form role="form" method="POST" action="{{ url('/password/email') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <fieldset>
                    <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control"
                                                                   placeholder="Email"
                                                                   name="email" value="{{ old('email') }}"/>
															<i class="ace-icon fa fa-envelope"></i>
														</span>
                    </label>

                    <div class="clearfix">
                        <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                            <i class="ace-icon fa fa-lightbulb-o"></i>
                            <span class="bigger-110">Send Me!</span>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
        <!-- /.widget-main -->

        <div class="toolbar center">
            <a href="{{ url('/auth/login') }}" data-target="#login-box" class="back-to-login-link">
                Back to login
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <!-- /.widget-body -->
</div>
<!-- /.forgot-box -->
@endsection

