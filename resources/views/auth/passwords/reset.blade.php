@extends('layouts.public')
@section('content')

    <div class="jumbotron">
        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <h3>Account Access</h3>

                    <p>Reset your password</p>

                </div>
            </div>
        </div>
    </div>
    <div class="container form">
        <div class="row">
            <div class="col-md-4">
                <div class="toggle">
                    <a style="color:#fff" href="/login"><i class="icon-times fa-key"></i>

                        <div class="tooltip" title="">Login</div>
                    </a>
                </div>

                <form method="POST" action="/password/reset">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        Email
                        <input type="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div>
                        Password
                        <input type="password" name="password">
                    </div>

                    <div>
                        Confirm Password
                        <input type="password" name="password_confirmation">
                    </div>

                    <div>
                        <br/>
                        <button class="btn btn-warning">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection