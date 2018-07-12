@extends('layouts.admin-template')
@section('title')
    @lang("Message Groups")
@endsection
@section('crumbs')
    <a href="/messaging/admin">@lang("Messaging")</a>
    <a href="#">@lang("Message groups")</a>
@endsection

@section('content')
    @include('messaging.topnav')
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-default">
                <div class="card-header bg_lg"><span class="icon"><i class="fa fa-envelope"></i></span>
                    <h5>@lang("Message Groups")</h5>
                </div>
                <div class="card-body">
                    @if(!empty($group))

                        {{Form::model($group,['url'=>'messaging/mail-groups/'.$group->id,'method'=>'patch'])}}

                        <ul class="nav nav-pills nav-stacked">
                            @include('messaging.users',['group'=>$group])
                        </ul>
                    @else
                        @foreach($groups as $gp)
                            <div class="callout callout-{{$gp->active==1?'success':'danger'}}">
                                <h4><a href="/messaging/mail-groups/{{$gp->id}}">{{$gp->name}}</a>
                                    <span class="badge right">{{!empty(explode(',',DB::table('messaging_groups')->where('id',$gp->id)->first()->users))}}</span>
                                </h4>
                                <em>{{$gp->desc}}</em>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-default">
                <div class="card-header bg_lg"><span class="icon"><i class="fa fa-envelope"></i></span>
                    <h5>@lang("Create/Edit Groups")</h5>
                </div>
                <div class="card-body">
                    @if(!empty($group))
                        <h4 class="title">@lang("Edit Group")</h4>
                    @else
                        {{Form::open(['url'=>'/messaging/mail-groups'])}}
                        <h4 class="title">@lang("New Group")</h4>
                    @endif
                    <label>@lang("Name")</label>
                    {{Form::text('name',null,['required'=>'required'])}}
                    <label>@lang("Description")</label>
                    {{Form::text('desc',null,['required'=>'required'])}}
                    <label>@lang("Active?")</label>
                    {{Form::select('active',[1=>__("Yes"),0=>__("No")])}}
                    <br/>
                    <button class="btn btn-inverse">@lang("Submit")</button>
                    {{Form::close()}}
                </div>
            </div>
        </div>

    </div>
@endsection
