@extends('layouts.public')
@section('content')

    <div class="jumbotron">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <h3>@lang("Account Access")</h3>

                    <p>@lang("Reset your password")</p>

                </div>
            </div>
        </div>
    </div>
    <div class="container form">
        <div class="row">
            <div class="col-md-4">
                <div class="toggle">
                    <a style="color:#fff" href="/login"><i class="fa fa-times fa-key"></i>

                        <div class="tooltip" title="">@lang("Login")</div>
                    </a>
                </div>

                <form method="POST" action="/password/reset">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" class="form-control" value="{{ $token }}">

                    <div>
                        @lang("Email")
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div>
                        @lang("Password")
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div>
                        @lang("Confirm Password")
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>

                    <div>
                        <br/>
                        <button class="btn btn-warning">
                            @lang("Reset Password")
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection