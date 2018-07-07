@extends('layouts.admin-template')
@section('title')
    @lang("Sent messages")
@endsection

@section('crumbs')
    <a href="/messaging/admin">@lang("Messaging")</a>
    <a href="#">@lang("Sent messages")</a>
@endsection

@section('content')
    @include('messaging.topnav')
    <div class="card card-default">
        <div class="card-header"><span class="icon"><i class="fa fa-th"></i></span>
            <h5>@lang("Previous Messages")</h5>
        </div>
        <div class="card-body nopadding">
            <table class="table table-striped " id="table">
                <thead>
                <tr>
                    <th>@lang("Date")</th>
                    <th>@lang("Subject")</th>
                    <th>@lang("Sender")</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($messages as $msg)
                    <tr>
                        <td>{{$msg->created_at}}</td>
                        <td>{{$msg->subject}}</td>
                        <td>
                            <?php $u = \App\User::find($msg->sender);
                            if (count($u)) {
                                $user = $u->first_name . ' ' . $u->last_name;
                            } else {
                                $user = "system";
                            }
                            ?>
                            {{$user}}
                        </td>
                        <td>
                            <a class="btn btn-default btn-sm" data-toggle="tooltip" title="@lang("Copy to start a new message")"
                               href="/messaging/admin?msg={{$msg->id}}"><i class="fa fa-copy"></i> </a>
                            <a class="btn btn-danger btn-sm  delete" data-toggle="tooltip" title="@lang("Delete")"
                               href="/messaging/delete/{{$msg->id}}"><i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $messages->links() !!}
        </div>
    </div>

@endsection
