@extends('layouts.template')
@section('title')
    Birthdays
@endsection

@section('content')

    @role('admin')
    <a href="/users" class="btn btn-default "><i class="icon-chevron-left"></i> @lang("Back to users")</a>
    <a href="/messaging/admin" class="btn btn-warning "><i class="icon-envelope-alt"></i> @lang("Send birthday
        message")</a>
    @endrole
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-share"></i></span>
                    <h5>@lang("Birthdays")</h5>
                </div>

                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">

                            <form method="get" id="search">
                                <div class="input-group">
                                    {{Form::select('m',$months)}}
                                    <span class="input-group-btn">
                                        <button class="btn btn-default">
                                            <i class="icon-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h4>
                        @if(isset($_GET['m']))
                            {{date("F", mktime(0, 0, 0, $_GET['m'], 10))}} Birthdays
                        @else
                            {{date('F')}} Birthdays
                        @endif
                    </h4>
                    <div class="row-fluid">
                        <div class="span12">
                            <table class="table table-striped table-responsive">
                                <tr>
                                    <th>@lang("Firstname")</th>
                                    <th>@lang("Lastname")</th>
                                    <th>@lang("Email")</th>
                                    <th>@lang("Phone")</th>
                                    <th>@lang("Birthday")</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->first_name}}</td>
                                        <td>{{$user->last_name}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->dob}}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection