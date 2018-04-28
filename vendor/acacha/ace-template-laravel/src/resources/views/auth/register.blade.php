@extends('auth.auth')

@section('content')
<div id="signup-box" class="signup-box widget-box no-border visible">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header green lighter bigger">
                <i class="ace-icon fa fa-users blue"></i>
                New User Registration
            </h4>

            <div class="space-6"></div>
            <p> Enter your details to begin: </p>

            <form role="form" method="POST" action="{{ url('/auth/register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="email"
                                   class="form-control"
                                   placeholder="Email"
                                   name="email"
                                   value="{{ old('email') }}"/>
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Username"
                                   name="name"
                                   value="{{ old('name') }}"/>
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password"
                                   class="form-control"
                                   placeholder="Password"
                                   name="password"/>
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>

                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password"
                                   class="form-control"
                                   placeholder="Repeat password"
                                   name="password_confirmation"/>
                            <i class="ace-icon fa fa-retweet"></i>
                        </span>
                    </label>

                    <!--<label class="block">
                        <input type="checkbox" class="ace"/>
                            <span class="lbl">
                                I accept the
                                <a href="#">User Agreement</a>
                            </span>
                    </label>-->

                    <div class="space-24"></div>

                    <div class="clearfix">
                        <button type="reset" class="width-30 pull-left btn btn-sm">
                            <i class="ace-icon fa fa-refresh"></i>
                            <span class="bigger-110">Reset</span>
                        </button>

                        <button type="submit"
                                class="width-65 pull-right btn btn-sm btn-success">
                            <span class="bigger-110">Register</span>

                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="toolbar center">
            <a href="{{ url('/auth/login') }}" data-target="#login-box" class="back-to-login-link">
                <i class="ace-icon fa fa-arrow-left"></i>
                Back to login
            </a>
        </div>
    </div>
    <!-- /.widget-body -->
</div>
<!-- /.signup-box -->
@endsection
