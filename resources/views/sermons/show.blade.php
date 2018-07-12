@extends('layouts.public')

@section('content')
	<div class="container">
		@if(empty($sermon))
			<h3>@lang('No sermon found')</h3>
		@else

			<div class="row">
				<div class="col-sm-9">

					<a href="/sermons"><i class="fa fa-chevron-left"></i>
						@lang("back to sermons")
					</a>

					<div class="row">
						<div class="col-sm-6">

							@if(Storage::exists($sermon->cover))

								<img class="thumbnail" style="heigth:100%;width:400px;"
									 src="{{Storage::url($sermon->cover)}}"/>
							@else

								{!! App\Tools::postThumb('none','85px','85px') !!}

							@endif
						</div>
						<div class="col-sm-6">
							<h3 class="method-title">{{$sermon->title}}</h3>
							{{date('d M, Y',strtotime($sermon->created_at))}}
							&nbsp;&nbsp;|&nbsp;&nbsp;
							@lang("Speaker"): {{$sermon->speaker}}
							&nbsp;&nbsp;|&nbsp;&nbsp;
							@lang("Scripture"): {{$sermon->scriptures}}

							<p><br/>
								@lang("Description"): {{$sermon->desc}}
							</p>

							<p>
								@lang("Topic"): {{$sermon->topic}}
								&nbsp;&nbsp;|&nbsp;&nbsp;
								@lang("Sub Topic"): {{$sermon->sub_topic}}
							</p>

							@if($sermon->audio =="")
								<button class="btn btn-primary disabled"><i class="fa fa-file-audio-o"></i>
									@lang("Play Audio")
								</button>
							@else
								<button class="btn btn-primary play-audio"><i class="fa fa-file-audio-o"></i>
									@lang("Play Audio")
								</button>
							@endif
							@if($sermon->video =="")
								<button class="btn btn-danger disabled"><i class="fa fa-video-camera"></i>
									@lang("Play Video")
								</button>
							@else
								<button class="btn btn-danger play-video"><i class="fa fa-video-camera"></i>
									@lang("Play Video")
								</button>
							@endif
							<button class="btn btn-success sermon-message"><i class="fa fa-eye-open"></i>
								@lang("Read Message")
							</button>

						</div>
					</div>
				</div>
				<div class="col-sm-3">
					@include('sermons.recent_sidebar')
				</div>
			</div>
		@endif
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">

        $('.play-audio').click(function () {
            $('#audio-modal').modal('show');
        });
        $('.sermon-message').click(function () {
            $('#message-modal').modal('show');
        });
        $('.play-video').click(function () {
            let div = $('#video-modal');
            let v = "{{$sermon->video}}";
            let video;
            if (youtube(v)) {
                video = v + "?color=white&iv_load_policy=3&rel=0&showinfo=0&theme=light";
            } else {
                div.find('iframe').attr('src', '/img/404.png');
            }

            div.find('iframe').attr('src', video);
            div.modal({
                //backdrop: 'static',
                keyboard: false
            });
        });
        $("#video-modal").find('.btn').on("click", function () {
            $("#video-modal").find('iframe').attr("src");
        });

	</script>

	<div class="modal fade" id="audio-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title" id="myModalLabel">{{$sermon->title}}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>
				<div class="modal-body">
					<audio style="width:100%" src="{{Storage::url($sermon->audio)}}"
						   controls="controls"></audio>
				</div>

			</div>
		</div>
	</div>
	<div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<iframe src="" style="width:100%" height="345" frameborder="0" allowfullscreen=""></iframe>

					<div class="row">
						<div class="col-sm-10"><h4>{{$sermon->title}}</h4></div>
						<div class="col-sm-2">
							<button type="button" class="btn btn-danger" style="float:right" data-dismiss="modal"
									aria-label="Close">@lang("Close")
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document" style="width:100%;">
			<div class="modal-content" style="-webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0;">
				<div class="modal-header">

					<h4 class="modal-title" id="myModalLabel">{{$sermon->title}}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					{!! $sermon->message !!}
				</div>
				<div class="modal-footer">

				</div>
			</div>
		</div>
	</div>

@endpush