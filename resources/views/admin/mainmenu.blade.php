@extends('layouts.template')
@section('title')
    Main Menu
@endsection
@section('crumbs')
    <a href="#" class="current">main menu</a>
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span2 btn-icon-pg">
            @include('admin.settings-menu')
        </div>

        <div class="span10">
            <div class="widget-box no-top">
                <div class="widget-title bg_lg"><span class="icon"><i class="icon-calendar"></i></span>
                    <h5>Main menu</h5>
                    <div class="buttons">
                        <a href="/settings/menu" class="btn btn-inverse btn-mini right">
                            <i class="icon-plus"></i>
                            New menu item
                        </a>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span8">
                            <div class="alert alert-info">
                                If you add sub-menu items and would like them to hide them from front-end, add <code>no-submenu</code>
                                parameter in your template navigation
                            </div>
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody class="sortable-rows">
                                @foreach($mainMenu as $m)
                                    <tr class="sortable-row" id="{{$m->id}}">
                                        <td>
                                            <a href="?m={{$m->id}}">{{$m->title}}</a>
                                        </td>
                                        <td>{{$m->order}}</td>
                                        <td>{!!($m->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
                                    </tr>
                                    @foreach($subMenu as $s)

                                        @if($m->id == $s->parent)
                                            <tr class="bg-info">
                                                <td style="text-indent: 25px;">
                                                    <a href="?m={{$s->id}}">{{$s->title}}</a>
                                                </td>
                                                <td>{{$s->order}}</td>
                                                <td>{!!($s->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="span4">

                            @if(count($menuItem))
                                <h4>Edit Menu Item</h4>
                                {{Form::model($menuItem,['url'=>'settings/menu/','method'=>'patch'])}}
                                {{Form::hidden('id',$menuItem->id)}}
                                <label>Title</label>
                                {{Form::text('title',null,['required'=>'required'])}}
                                <label>Path</label>
                                {{Form::text('path',null,['required'=>'required','placeholder'=>'e.g. /home'])}}
                                <label>Parent</label>
                                {!! Form::select('parent',$items,$menuItem->parent) !!}
                                <br/>

                                <label>Order</label>
                                {{Form::text('order',null,['required'=>'required'])}}
                                <label>Icon</label>
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

                                <button class="btn btn-default"><i class="icon-save"></i> Save</button>
                                <a href="/settings/menu" class="btn btn-danger right"><i class="icon-eye-close"></i>
                                    Close</a>

                                {{Form::close()}}

                            @else
                                <h4>New Menu Item</h4>
                                {{Form::open(['url'=>'settings/menu'])}}
                                <label>Title</label>
                                {{Form::text('title',null,['required'=>'required'])}}
                                <label>Path</label>
                                {{Form::text('path',null,['required'=>'required','placeholder'=>'e.g. /home'])}}
                                <label>Parent</label>
                                <select name="parent" class="select2">
                                    <option value="0">--NONE--</option>
                                    @foreach($menu as $p)
                                        <option value="{{$p->id}}">{{$p->title}}</option>
                                    @endforeach
                                </select>
                                <br/>

                                <label>Order</label>
                                {{Form::text('order',null,['required'=>'required'])}}
                                <label>Icon</label>
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
                                <button class="btn btn-default">Save</button>

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
            url: "/settings/menu/sort",
            data: dataString,
            cache: false,
            success: function (data) {
            }
        });
    }
</script>
@endpush