@extends('layouts.admin-template')
@section('title')
	<i class="fa fa-money"></i> @lang("Giving options")
@endsection

@section('content')
	<div class="row">
		@include('admin.settings-menu')

		<div class="col-sm-9">
			<div class="card card-default no-top">
				<div class="card-header bg_lg">
					<div class="buttons">
						<a class="btn btn-inverse btn-sm" href="/giving/gift-options">
							<i class="fa fa-plus"></i>
							@lang("New gift option")</a>
					</div>
				</div>
			</div>

			<div class="card card-default no-top">
				<div class="card-body">
					<div class="alert alert-info">
						@lang("These are the options available to members to choose from when giving online")
						@lang("Example: Building fund, overseas missions, etc")
					</div>
					<div class="row">
						<div class="col-sm-6">
							<table class="table table-striped" id="table-basic">
								@foreach($gOptions as $go)
									<tr class="@if($go->active==0) bg-danger @endif">
										<td>
											<a href="?option={{$go->id}}">{{$go->name}}</a>
											<em class="text-danger">
												@if($go->active==0)
													@lang("inactive")
												@endif
											</em>
										</td>
										<td>
											{!! $go->desc !!}
										</td>
									</tr>
								@endforeach
							</table>
						</div>
						<div class="col-sm-6">
							@if(isset($_GET['option']) && $_GET['option'] !=="")
								{!! Form::model($gOption,['url'=>'giving/gift-options/'.$gOption->id,'method'=>'put']) !!}
								<h4>@lang("Edit option")</h4>
							@else
								{!! Form::open(['url'=>'giving/gift-options','method'=>'post']) !!}
								<h4>@lang("New option")</h4>
							@endif
							{{Form::label('name',__('Name'))}}
							{{Form::text('name',null,['required'=>'required','class'=>'form-control'])}}

							{{Form::label('amount',__('Amount'))}} <i class="small">(@lang("optional")</i>
							{{ Form::input('number','amount',null,['class'=>'form-control','required'=>'']) }}

							{{Form::label('desc',__('Description'))}}
							{{Form::textarea('desc',null,['required'=>'required','rows'=>3,'class'=>'col-sm-12 form-control'])}}

							{{Form::label('active',__('Active'))}}
							{{Form::select('active',[1=>'Yes',0=>'No'],null,['class'=>'form-control'])}}
							<br/>
							@if(isset($_GET['option']) && $_GET['option'] !=="")
								<button class="btn btn-inverse">@lang("Update")</button>
								<a href="{{route('gift-options')}}" class="btn btn-danger pull-right">
									@lang('Close')
								</a>
							@else

								<button class="btn btn-inverse">@lang("Submit")</button>
							@endif

							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection