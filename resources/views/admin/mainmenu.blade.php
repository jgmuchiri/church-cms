@extends('layouts.admin-template')
@section('title')
    @lang("Main Menu")
@endsection
@section('crumbs')
    <a href="#" class="current">@lang("main menu")</a>
@endsection

@section('content')
    <div class="row-fluid">
        @include('admin.settings-menu')

        <div class="span10">
            <div class="widget-box no-top">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
                    <h5>@lang("Main menu")</h5>
                    <div class="buttons">
                        <a href="/menu" class="btn btn-inverse btn-mini right">
                            <i class="icon-plus"></i>
                            @lang("New menu item")
                        </a>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <div class="alert alert-info">
                               @lang(" If you add sub-menu items and would like them to hide them from front-end, add") <code>@lang("no-submenu")</code>
                                @lang("parameter in your template navigation")
                                <br/>
                                @lang("Default menu")
                                <code>/home</code>
                                <code>/sermons</code>
                                <code>/events</code>
                                <code>/ministries</code>
                                <code>/blog</code>
                                <code>/contact</code>
                                <code>/account</code>
                                <code>/login</code>
                            </div>
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>@lang("Menu")</th>
                                    <th>@lang("Order")</th>
                                    <th>@lang("Icon")</th>
                                    <th>@lang("Status")</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="sortable-rows">
                                @foreach($mainMenu as $m)
                                    <tr class="sortable-row" id="{{$m->id}}">
                                        <td>
                                            <a href="?m={{$m->id}}">{{$m->title}}</a>
                                        </td>
                                        <td>{{$m->order}}</td>
                                        <td><i class="icon-{{$m->icon}}"></i> </td>
                                        <td>{!!($m->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
                                        <td>
                                            <a href="/menu/delete/{{$m->id}}"></a>
                                        </td>
                                    </tr>
                                    @foreach($subMenu as $s)

                                        @if($m->id == $s->parent)
                                            <tr class="bg-info">
                                                <td style="text-indent: 25px;">
                                                    <a href="?m={{$s->id}}">{{$s->title}}</a>
                                                </td>
                                                <td>{{$s->order}}</td>
                                                <td><i class="icon-{{$s->icon}}"></i> </td>
                                                    <td>{!!($s->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
                                                <td>
                                                    <a href="/menu/delete/{{$s->id}}"></a>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="span4">

                            @if(count($menuItem))
                                <h4>@lang("Edit Menu Item")</h4>
                                {{Form::model($menuItem,['url'=>'menu/','method'=>'patch'])}}
                                {{Form::hidden('id',$menuItem->id)}}
                                <label>@lang("Title")</label>
                                {{Form::text('title',null,['required'=>'required'])}}
                                <label>@lang("Path")</label>
                                {{Form::text('path',null,['required'=>'required','placeholder'=>'e.g. /home'])}}
                                <label>@lang("Parent")</label>
                                {!! Form::select('parent',$items,$menuItem->parent) !!}
                                <br/>

                                <label>@lang("Order")</label>
                                {{Form::text('order',null,['required'=>'required'])}}
                                <label>@lang("Icon")</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <span class="addon span1">
                                            <i id="fa-icon" class="@if(!empty($menuItem->icon))icon-{{$menuItem->icon}} @endif"></i>
                                        </span>
                                        <select name="icon" class="select2 span9">
                                            @foreach(\App\Tools::fa() as $f)
                                                <option value="{{$f}}">fa-{{$f}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <br/>
                                {{Form::select('active',['1'=>'active','0'=>'disabled'])}}
                                <br/>

                                <button class="btn btn-default"><i class="icon-save"></i> @lang("Save")</button>
                                <a href="/menu" class="btn btn-danger right"><i class="icon-eye-close"></i>
                                    @lang("Close")</a>

                                {{Form::close()}}

                            @else
                                <h4>@lang("New Menu Item")</h4>
                                {{Form::open(['url'=>'menu'])}}
                                <label>@lang("Title")</label>
                                {{Form::text('title',null,['required'=>'required'])}}
                                <label>@lang("Path")</label>
                                {{Form::text('path',null,['required'=>'required','placeholder'=>'e.g. /home'])}}
                                <label>@lang("Parent")</label>
                                <select name="parent" class="select2">
                                    <option value="0">--NONE--</option>
                                    @foreach($menu as $p)
                                        <option value="{{$p->id}}">{{$p->title}}</option>
                                    @endforeach
                                </select>
                                <br/>

                                <label>@lang("Order")</label>
                                {{Form::text('order',null,['required'=>'required'])}}
                                <label>@lang("Icon")</label>
                                <div class="controls">
                                    <div class="input-group">
                                        <span class="addon span1">
                                            <i id="fa-icon"></i>
                                        </span>
                                        <select name="icon" class="select2 span9">
                                            @foreach(\App\Tools::fa() as $f)
                                                <option value="{{$f}}">fa-{{$f}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <br/>
                                {{Form::select('active',['1'=>'active','0'=>'disabled'])}}

                                <br/>
                                <button class="btn btn-default">@lang("Save")</button>

                                {{Form::close()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('partials.select2',['select2'=>'.select2'])
@push('styles')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endpush

@push('scripts')

<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $('select[name=icon]').on('change',function () {
        var fa = $(this).val();
        $('#fa-icon').attr('class','icon-'+fa);
    })
    $(function () {
        $(".sortable-rows").sortable({
            placeholder: "ui-state-highlight",
            update: function (event, ui) {
                updateDisplayOrder();
            }
        });
    });
    // function to save display sort order
    function updateDisplayOrder() {
        var selectedLanguage = [];
        $('.sortable-rows .sortable-row').each(function () {
            selectedLanguage.push($(this).attr("id"));
        });
        var dataString = 'sort_order=' + selectedLanguage + '&_token={{csrf_token()}}';

        $.ajax({
            type: "POST",
            url: "/menu/sort",
            data: dataString,
            cache: false,
            success: function (data) {
            }
        });
    }
</script>
@endpush