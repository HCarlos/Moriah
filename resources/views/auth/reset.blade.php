@extends('auth.auth')

@section('content')
    <div id="reset-password-box" class="login-box visible widget-box no-border">
        <div class="widget-body">
            <div class="widget-main">
                <h4 class="header blue lighter bigger">
                    <i class="ace-icon fa fa-coffee green"></i>
                    Reset password
                </h4>

                <div class="space-6"></div>

                <form role="form" method="POST" action="{{ url('/password/reset') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <fieldset>
                        <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="email" class="form-control"
                                   placeholder="Email" name="email"
                                   value="{{ old('email') }}"/>
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                        </label>

                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control"
                                       placeholder="Password" name="password"/>
                                <i class="ace-icon fa fa-lock"></i>
                            </span>
                        </label>

                        <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                                <input type="password" class="form-control"
                                       placeholder="Confirm password"
                                       name="password_confirmation">
                                <i class="ace-icon fa fa-lock"></i>
                            </span>
                        </label>

                        <div class="space"></div>

                        <div class="clearfix">
                            <button type="submit"
                                    class="width-50 pull-right btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-key"></i>
                                <span class="bigger-110">Reset password</span>
                            </button>
                        </div>

                        <div class="space-4"></div>
                    </fieldset>
                </form>
            </div>
            <!-- /.widget-main -->
        </div>
        <!-- /.widget-body -->
    </div>
    <!-- /.reset-password-box -->
@endsection
