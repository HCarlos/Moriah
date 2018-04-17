@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-moriah center-block" id="frmEditProfile1">
                    <div class="panel-heading">
                            <span><strong>Cambiar Email | {{$user->username}}</strong>
                            </span>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{ action('Auth\EditUserDataController@changeEmailUser',['user'=>$user]) }}" >
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group row">
                                <label for="email_old" class="col-md-4 col-form-label text-md-right">Email Actual</label>
                                <div class="col-md-6">
                                    <input id="email_old" type="text" class="form-control" name="email_old" value="{{$user->email}}" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail nuevo</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus/>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="col-md-2 col-form-label text-md-right"></label>
                                <div class="col-md-8" >
                                    <button type="submit" class="btn btn-primary">
                                        Cambiar email
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

