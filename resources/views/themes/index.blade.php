@extends('layouts.template')
@section('title')
    Themes
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-list"></i></span>
            <h5>
                Current theme:
                <strong class="text-info">{{App\Models\Themes::currentTheme()}}</strong></h5>

            <div class="buttons">
                <a href="#" class="btn btn-primary btn-mini" data-toggle="modal" data-target="#myModal"><i
                            class="icon-plus"></i>
                    Upload theme</a>

                <a href="/settings/themes/1/select" class="btn btn-info btn-mini"><i
                            class="icon-check"></i> Set default theme</a>

                <a href="/themes/browse" target="_blank" class="btn btn-warning btn-mini"><i
                            class="icon-shopping-cart"></i>
                    Browse themes</a>
            </div>
        </div>
        <div class="widget-content">

            <div class="row-fluid">
                @foreach($themes as $theme)
                    <div class="span4">
                        <div style="max-height: 360px;background:#f2f2f6;padding:10px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
                            <h3>{{$theme->name}}</h3>

                            <div class="thumbnail">
                                <img style="width:100%;height:100%;height: 150px;"
                                     src="/themes/{{$theme->location}}/screenshot.png"/>
                            </div>
                            <div class="caption">
                                {{$theme->desc}}
                            </div>
                            <hr/>
                            @if(App\Models\Settings::get_option('active_theme') ==$theme->id)
                                <a class="btn btn-primary active"><i class="icon-check"></i></a>
                            @else
                                {{--<a href="/settings/themes/{{$theme->id}}/preview" target="_blank" class="btn btn-info btn-mini"><i class="icon-eye"></i> Preview</a>--}}
                                @if(App\Models\Settings::get_option('site_theme')==$theme->id)
                                    <button class="btn btn-success btn-mini"><i class="icon-check"></i> Active theme
                                    </button>
                                @else
                                    <a href="/settings/themes/{{$theme->id}}/select" class="btn btn-info btn-mini"><i
                                                class="icon-check"></i> Select theme</a>
                                @endif
                            @endif
                            <a href="/settings/themes/{{$theme->id}}/delete" class="btn btn-danger btn-mini delete"><i
                                        class="icon-trash"></i> Delete</a>

                        </div>
                    </div>

                @endforeach
            </div>

            <div style="clear:both;display:block;"></div>
        </div>
    </div>
@endsection
@push('modals')
<div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="icon-upload"></i> Upload a theme
                </h4>
            </div>
            {!! Form::open(['url'=>'settings/themes','files'=>true]) !!}
            <div class="modal-body">
                <label>Theme files (.zip)
                    <i class="icon-info-circle"
                                             data-toggle="popover"
                                             data-trigger="hover"
                                             title="Theme structure"
                                             data-html="true"
                                             data-content="<img src='/img/structure.png' style='width:100%'>"></i>
                </label>
                {!! Form::file('theme') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Upload</button>
            </div>
            <div class="callout callout-warning">Theme files must contain index.blade.php and screenshot.png</div>
        </div>
    </div>
</div>
@endpush