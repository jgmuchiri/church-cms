@extends('layouts.template')
@section('title')
    Support admin
@endsection
@section('content')
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-question-sign"></i></span>
                <h5>Support topics</h5>
                <div class="buttons">
                    <a href="/support/categories" class="btn btn-info btn-mini"><i class="icon-list"></i> Knowledge Base
                        Categories</a>
                    <a href="/support/create" class="btn btn-info btn-mini">
                        <i class="icon-plus"></i> New Support Topic</a>
                    <a href="/support" class="btn btn-primary btn-mini">
                        <i class="icon-home"></i> User view</a>
                </div>
            </div>
            <div class="widget-content">
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">

                        <thead>
                        <tr>
                            <th>Question</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Status</th>
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
                                        <i class="label label-success">published</i>
                                    @else
                                        <i class="label label-danger">pending</i>
                                    @endif
                                </td>
                                <td>
                                    <a class="delete btn btn-danger btn-mini" href="/support/question/{{$q->id}}/delete"><i
                                                class="icon-trash"></i> </a>
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