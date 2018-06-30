@extends('layouts.admin-template')
@section('title')
    {{$title}}
@endsection
@section('crumbs')
    <a href="#">{{$title}}</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-th"></i></span>
            <h5>{{$title}}</h5>

            <div class="buttons">
                <a href="/ministries" class="btn btn-info btn-mini">
                    <i class="icon-home"></i> @lang("Ministries Homepage")
                </a>
                <a href="/ministries/categories" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> @lang("Categories")
                </a>
                <a href="/ministries/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> @lang("New Ministry")
                </a>
            </div>
        </div>
        <div class="widget-content">
            <div class="row-fluid">

                <div class="span12">

                    <form class="form-inline" method="get">
                        <div class="controls">
                            <div class="input-group">
                                <span class="add-on">
                                @if(isset($_GET['s']))
                                    <a href="/ministries/admin" class="btn btn-inverse">
                                        <i class="icon-arrow-left"></i>
                                    </a>
                                @endif
                                    </span>
                                <input type="text" name="s" placeholder="Search by name" class="form-control"/>
                                <button class="btn btn-default"><i class="icon-search"></i></button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(count($ministries)>0)
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>@lang("Date")</th>
                        <th>@lang("Category")</th>
                        <th>@lang("Title")</th>
                        <th>@lang("Created On")</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ministries as $m)
                        <tr>
                            <td>
                                @if($m->active == 0)
                                    <i class="icon-times-circle text-danger"></i>
                                @else
                                    <i class=" icon-check text-success"></i>
                                @endif
                                {{date('d M y',strtotime($m->created_at))}}

                            </td>
                            <td>
                                {{DB::table('ministry_cats')->whereId($m->cat)->first()->name}}
                            </td>
                            <td>{{$m->name}}</td>
                            <td>{{date('d M, Y',strtotime($m->created_at))}}</td>
                            <td>
                                <a class="btn btn-mini btn-inverse" href="/ministries/{{$m->slug}}?preview" target="_blank">
                                    <i class="icon-external-link"></i> @lang("preview") </a>
                                <a href="/ministries/{{$m->id}}/edit" class="btn btn-info btn-mini edit">
                                    <i class="icon-pencil"></i> @lang("edit")</a>
                                <a href="/ministries/{{$m->id}}/delete" class="btn btn-danger btn-mini  delete">
                                    <i class="icon-trash"></i> @lang("delete")</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$ministries->links()}}
            @else
                <hr/>
                <div class="alert alert-danger">@lang("No records found")</div>
            @endif
        </div>
    </div>

@endsection
@push('scripts')
<script>
    $('.delete').click(function (e) {
        if (confirm('@lang("Are you sure?")')) {
            return true;
        }
        e.preventDefault();
        return false;
    })
</script>
@endpush