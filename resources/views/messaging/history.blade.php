@extends('layouts.template')
@section('title')
    @lang("Sent messages")
@endsection

@section('crumbs')
    <a href="/messaging/admin">@lang("Messaging")</a>
    <a href="#">@lang("Sent messages")</a>
@endsection

@section('content')
    @include('messaging.topnav')
    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("Previous Messages")</h5>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-striped table-responsive" id="table">
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
                            <a class="btn btn-default btn-mini" data-toggle="tooltip" title="@lang("Copy to start a new message")"
                               href="/messaging/admin?msg={{$msg->id}}"><i class="icon-copy"></i> </a>
                            <a class="btn btn-danger btn-mini  delete" data-toggle="tooltip" title="@lang("Delete")"
                               href="/messaging/delete/{{$msg->id}}"><i class="icon-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $messages->links() !!}
        </div>
    </div>

@endsection
