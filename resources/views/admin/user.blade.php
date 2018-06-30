@extends('layouts.admin-template')
@section('title')
    User- {{$user->username}}
@endsection
@section('title-icon')user
@endsection

@section('content')
    <a href="/users" class="btn btn-mini btn-default"><i class="icon-chevron-left"></i> </a>

    <div class="widget-box">
        <div class="widget-title">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#profile">@lang("Home")</a></li>
                <li><a data-toggle="tab" href="#giving">@lang("Manual Giving")</a></li>
                <li><a data-toggle="tab" href="#history">@lang("Giving History")</a></li>
                <li><a data-toggle="tab" href="#roles">@lang("Roles & Permissions")</a></li>
            </ul>
        </div>
        <div class="widget-content tab-content">
            <div id="profile" class="tab-pane active">
                {!! Form::model($user,['url'=>'user/'.$user->id]) !!}
                <table class="table table-striped">
                    <tr>
                        <td>@lang("First name:")</td>
                        <td>{{Form::text('first_name')}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Last name:")</td>
                        <td>{{Form::text('last_name')}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Email:")</td>
                        <td>{{Form::input('email','email')}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Phone:")</td>
                        <td>{{Form::text('phone')}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Address:")</td>
                        <td>{{Form::textarea('address',null,['rows'=>3])}}</td>
                    </tr>
                    <tr>
                        <td>@lang("DOB:")</td>
                        <td>{{Form::input('date','dob')}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Stripe ID:")</td>
                        <td>{{$user->stripe_id}}</td>
                    </tr>
                    <tr>
                        <td>@lang("Registered:")</td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </div>
            <div id="giving" class="tab-pane">
                @include('giving.manual_txn')
            </div>
            <div id="history" class="tab-pane">
                @include('giving.giving_history')
            </div>
            <div id="roles" class="tab-pane">
                {!! Form::open(['url'=>'user/'.$user->id.'/roles', 'files' => true]) !!}
                <?php
                function is_checked($user_id, $role)
                {
                    $userRoles = DB::table('role_user')->whereUserId($user_id)->get();
                    foreach ($userRoles as $ur) {
                        if ($ur->role_id == $role) return 'true';
                    }
                    return "";
                }
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table table-striped">
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{Form::radio('role',$role->id,(int)$currentRole==(int)$role->id)}}
                                    </td>
                                    <td valign="middle">{{ucwords($role->name)}}</td>
                                    <td> {{$role->description}}</td>
                                    <td>
                                        @foreach($role->permissions as $rp)
                                            <span class="label label-default"> {{$rp->name}}</span>
                                        @endforeach
                                    </td>
                                </tr>

                            @endforeach
                            <tr>
                                <td></td>
                                <td colspan="3">
                                    <button class="btn btn-info">Update user roles</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script src="/plugins/numeraljs/numeral.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('input[name=amount]').on('blur', function () {
            var cur = $(this).val();
            var am = numeral(cur).format('0.00');
            $(this).val(am);
        });
    });
</script>
@endpush