@extends('layouts.public')

@section('title')
	@if(isset($_GET['cat']))
		{{ucwords($cat->name)}}
	@elseif(Request()->segment('2'))
		{{ucwords($ministry->name)}} @lang("Ministry")
	@else
		@lang("Ministries")
	@endif
@endsection

@section('content')

	<div class="row">
		<div class="col-sm-2">
			@include('ministries.ministry-cats')
		</div>
		<div class="col-sm-10">

			<div class="small">
				@if(isset($_GET['cat']))
					{!! $cat->desc !!}
				@endif
			</div>

			<div class="row">
				@foreach($ministries as $m)
					<div class="col-sm-4">
						<div class="panel panel-default" style="height:100px;">
							<div class="panel-heading" style="height:30px;overflow: hidden;;">
                                <span class="panel-title">
                                    <a href="/ministries/{{$m->id}}">{{$m->name}}</a>
                                </span>
							</div>
							<div style="font-size:12px;padding:5px;">
								<div class="row">
									<div class="col-sm-4">
										{!! App\Tools::postThumb($m->desc,"100%",'60px') !!}
									</div>
									<div class="col-sm-8">
										{!! str_limit(strip_tags($m->desc),100,'...') !!}
									</div>
								</div>
							</div>

						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endsection
