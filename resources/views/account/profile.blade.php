@extends('layouts.template')
@section('title') Edit profile @endsection
@section('crumbs')
    <a href="/account">Account</a>
    <a href="#" class="current">My profile</a>
    @endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
            <h5>{{$user->username}}</h5>

            <div class="buttons">
                <strong>Registered:</strong> {{$user->created_at}}
                @if(!empty($user->stripe_id))
                    <strong>TXN ID:</strong> {{$user->stripe_id}}
                @endif

            </div>
        </div>
        <div class="widget-content">
            {!! Form::model($user,['url'=>'profile']) !!}
            <div class="row-fluid">
                <div class="span6">
                    <label>First name</label>
                    {{Form::text('first_name')}}

                    <label>Last name</label>
                    {{Form::text('last_name')}}

                    <label>Email</label>
                    {{Form::input('email','email')}}

                    <label>Phone</label>
                    {{Form::text('phone')}}
                </div>
                <div class="span6">
                    <label>Address</label>
                    {{Form::textarea('address',null,['rows'=>3])}}

                    <label>DOB</label>
                    {{Form::input('date','dob')}}

                    <div class="callout callout-danger">
                        <label>Password: <em>(only if changing)</em></label>
                        {!! Form::input('password','password') !!}
                        <label>Confirm Password:</label>
                        {!! Form::input('password','password_confirmation') !!}
                    </div>

                    {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>


@stop