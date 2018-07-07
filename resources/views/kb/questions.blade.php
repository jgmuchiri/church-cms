@extends('layouts.admin-template')
@section('title')
    @lang("Support admin")
@endsection
@section('content')
    <div class="row">
        <div class="card card-default">
            <div class="card-header bg_lg"><span class="icon"><i class="fa fa-question-sign"></i></span>
                <h5>@lang("Support topics")</h5>
                <div class="buttons">
                    <a href="/support/categories" class="btn btn-info btn-sm"><i class="fa fa-list"></i> @lang("Knowledge Base")
                        @lang("Categories")</a>
                    <a href="/support/create" class="btn btn-info btn-sm">
                        <i class="fa fa-plus"></i> @lang("New support topic")</a>
                    <a href="/support" class="btn btn-primary btn-sm">
                        <i class="fa fa-home"></i> @lang("User view")</a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-body nopadding">
                    <table class="table table-bordered data-table">

                        <thead>
                        <tr>
                            <th>@lang("Question")</th>
                            <th>@lang("Description")</th>
                            <th>@lang("Date Created")</th>
                            <th>@lang("Date Updated")</th>
                            <th>@lang("Status")</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $q)
                            <tr>
                                <td><a href="/support/question/{{$q->id}}">{{$q->question}}</a></td>
                                <td>{{stripslashes(strip_tags(str_limit($q->question_desc,100,'...')))}}</td>
                                <td>{{$q->created_at}}</td>
                                <td>{{$q->updated_at}}</td>
                                <td>
                                    @if($q->active ==1)
                                        <i class="label label-success">
                                            @lang("published")
                                        </i>
                                    @else
                                        <i class="label label-danger">
                                            @lang("pending")
                                        </i>
                                    @endif
                                </td>
                                <td>
                                    <a class="delete btn btn-danger btn-sm" href="/support/question/{{$q->id}}/delete"><i
                                                class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@endsection
@include('partials.datatables')