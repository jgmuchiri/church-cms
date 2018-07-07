@extends('layouts.admin-template')
@section('title')
    Blog Articles
@endsection
@section('crumbs')
    <a href="#" class="current">@lang("Blog")</a>
@endsection

@section('content')
    <div class="row">
        <div class="card card-default">
            <div class="card-header bg_lg"><span class="icon"><i class="fa fa-th"></i></span>
                <h5>@lang("Blog admin")</h5>
                <div class="buttons">
                    <a href="/blog" class="btn btn-default btn-sm"><i class="fa fa-home"></i> @lang("Blog Homepage")</a>
                    <a href="/blog/categories" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>
                        Categories</a>
                    <a href="/blog/create" class="btn btn-inverse btn-sm"><i class="fa fa-plus"></i>
                        @lang("New Post")</a>
                </div>
            </div>
            <div class="card-body">

                <ul class="stat-boxes2">
                    <li>
                        <div class="right">
                            <strong>{{count($blog->where('status','published'))}}</strong> Published
                        </div>
                    </li>

                    <li>
                        <div class="right">
                            <strong>{{count($blog->where('status','draft'))}}</strong> Draft(s)
                        </div>
                    </li>
                </ul>

                <form class="form-inline" method="get">
                    <span class="input-addon">
                         @if(isset($_GET['s']))
                            <a href="/blog/admin" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                        @endif
                    </span>
                    <input type="text" name="s" placeholder="Search by ID or Name" class="form-control"/>
                    <button class="btn btn-default"><i class="fa fa-search"></i></button>
                </form>

                    @if(count($blog)>0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>@lang("Date")</th>
                                <th>@lang("Title")</th>
                                <th>@lang("Body")</th>
                                <th>@lang("Posted by")</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($blog as $n)
                                <tr>
                                    <td>
                                        @if($n->status == 'draft')
                                            <i class="fa fa-times-circle text-danger"></i>
                                        @else
                                            <i class="fa fa-check text-success"></i>
                                        @endif
                                        {{date('d M y',strtotime($n->created_at))}}

                                    </td>
                                    <td><a target="_blank" href="/blog/{{$n->id}}">{{$n->title}}</a></td>
                                    <td>{!! str_limit(strip_tags($n->body),20,'...') !!}</td>
                                    <td>
                                        <?php $user = App\User::find($n->user_id); ?>
                                        @if(count($user))
                                            {{$user->last_name}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/blog/{{$n->id}}/edit" class="btn btn-info btn-sm edit"><i
                                                    class="fa fa-pencil"></i></a>

                                        <a href="/blog/{{$n->id}}/delete" class="btn btn-danger btn-sm delete"><i
                                                    class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="text-center">{{$blog->render()}}</div>
                    @else
                        <hr/>
                        <div class="alert alert-danger">@lang("No records found")</div>
                    @endif
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    $('.delete').click(function (e) {
        if (confirm('Are you sure?')) {
            return true;
        }
        e.preventDefault();
        return false;
    })
</script>
@endpush