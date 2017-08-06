@extends('layouts.template')
@section('crumbs')
    <a href="#">Messaging</a>
@endsection
@section('title')
    Messaging
@endsection
@section('content')
    @include('messaging.topnav')

    <div class="row-fluid">
        <div class="alert alert-info">
            A log of sent messages is kept in the server and can be re-used as template.
        </div>
        {!! Form::open(['url'=>'messaging/send','id'=>'template-form']) !!}
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Groups</a></li>
                    <li><a data-toggle="tab" href="#tab2">Find user</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <select name="group" id="user-groups" class="span6">
                        <option value="">--Select User Group--</option>
                        <option value="all">All Users</option>
                        <option value="admins">Admins</option>
                        <option value="moderators">Moderators</option>
                        <option value="users">Users</option>
                        <option value="bday-d">Today's Birthdays</option>
                        <option value="bday-m">This Month's Birthdays</option>

                        @foreach(DB::table('messaging_groups')->where('active',1)->get() as $gp)
                            <option value="{{$gp->id}}">{{$gp->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="tab2" class="tab-pane">
                    <div class="row-fluid">
                        <div class="span6">
                            {{Form::text('users[]',null,['id'=>'names','placeholder'=>'Start typing to search...','class'=>'span12'])}}
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <div class="span6">
                        <label><i class="icon-arrow-circle-right"></i> Subject</label>
                        {{Form::text('subject',null,['required'=>'required','class'=>'span12'])}}
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span10">
                        <label><i class="icon-arrow-circle-right"></i> Message</label>
                        @if($template ==null)
                            {{Form::textarea('message',null,['class'=>'editor span12'])}}
                        @else
                            {{Form::textarea('message',$template,['class'=>'editor span12'])}}
                        @endif
                    </div>
                </div>
                <br/>
                <div class="row-fluid">
                    <div class="span-12">
                        <button type="button" class="btn btn-info send">
                            <i class="icon-envelope-alt"></i> Send
                        </button>

                        <button type="button" class="btn btn-inverse draft pull-right">
                            <i class="icon-save"></i> Save asTemplate
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
@include('partials.tinymce')
@include('partials.token-users')
@push('scripts')
<script type="text/javascript">
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('form input[name=email]').val('');
        $('form #names').val('');
        $('form #user-groups').val('');
    });

    var form;
    form = $('#template-form');
    $('.draft').click(function (e) {
        var subject = form.find('input[name=subject]').val();
        if (subject === '') {
            swal('No subject entered');
            return;
        }
        form.append('<input type="hidden" name="active" value="1">');
        form.append('<input type="hidden" name="desc" value="' + subject + '">');
        form.find('input[name=subject]').attr('name', 'name');
        form.find('textarea[name=message]').attr('name', 'body');
        form.attr('action', '/templates');
        form.submit();
        e.preventDefault();
    });
    $('.send').click(function () {
        form.attr('action', '/messaging/send');
        var subject = form.find('input[name=subject]').val();
        if (subject === '') {
            swal('No subject entered');
            return;
        }
        form.find('input[name=desc]').remove();
        form.find('input[name=name]').attr('name', 'subject');
        form.find('input[name=active]').remove();
        form.find('textarea[name=body]').attr('name', 'message');
        form.submit();
        e.preventDefault();
    });
</script>
@endpush