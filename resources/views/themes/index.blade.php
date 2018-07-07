@extends('layouts.admin-template')
@section('title')
	<i class="fa fa-cloud-upload"></i>   @lang("Themes")
@endsection

@section('content')
	<div class="row">
		<div class="col-sm-6">
			<div class="card card-default">
				<div class="card-header">
					<strong>
						@lang("Current theme"):
						<strong class="text-info">{{App\Models\Themes::currentTheme()}}</strong>
					</strong>
					<a class="pull-right btn btn-primary btn-xs" href="/" target="_blank">
						 @lang('Preview') <i class="fa fa-external-link"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="card card-default">
				<div class="card-header">
					<div class="buttons">
						<a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
							<i class="fa fa-plus"></i>
							@lang("Upload theme")
						</a>
						<a href="/theme/0/select" class="btn btn-info btn-sm"><i class="fa fa-check"></i>
							@lang("Set default theme")
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card card-default">
		<div class="card-body">
			<div class="row">
				@foreach($themes as $theme)
					<div class="col-sm-4">
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
								<a class="btn btn-primary active"><i class="fa fa-check"></i></a>
							@else
								{{--<a href="/themes/{{$theme->id}}/preview" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Preview</a>--}}
								@if(App\Models\Settings::get_option('site_theme')==$theme->id)
									<button class="btn btn-success btn-sm"><i class="fa fa-check"></i>
										@lang("Active theme")
									</button>
								@else
									<a href="/theme/{{$theme->id}}/select" class="btn btn-info btn-sm"><i
												class="fa fa-check"></i>
										@lang("Select theme")
									</a>
								@endif
							@endif
							<a href="/theme/{{$theme->id}}/d" class="btn btn-danger btn-sm delete"><i
										class="fa fa-trash"></i> @lang("Delete")</a>

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
						<i class="fa fa-upload"></i> @lang("Upload a theme")
					</h4>
				</div>
				{!! Form::open(['url'=>'theme','files'=>true]) !!}
				<div class="modal-body">
					<label>@lang("Theme files") (.zip)
						<i class="fa fa-info-circle"
						   data-toggle="popover"
						   data-trigger="hover"
						   title="@lang("Theme structure")"
						   data-html="true"
						   data-content="<img src='/img/structure.png' style='width:100%'>"></i>
					</label>
					{!! Form::file('theme') !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
					<button class="btn btn-primary">@lang("Upload")</button>
				</div>
				<div class="callout callout-warning">@lang("Theme files must contain ",['opts'=>"index.blade.php and screenshot.png"]) </div>
			</div>
		</div>
	</div>
@endpush