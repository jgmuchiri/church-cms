@extends('layouts.public')

@section('title')
	@lang('sermons')
@endsection

@section('content')

	<div class="row">
		<div class="col-sm-9">
			@if(empty($sermon))
				@lang('No sermon found')
			@else
				<div class="row">
					<div class="col-sm-3">

						@if(Storage::exists($sermon->cover))

							<img class="thumbnail" style="heigth:100%;width:100%;"
								 src="{{Storage::url($sermon->cover)}}"/>
						@else

							{!! App\Tools::postThumb('none','100%','100%') !!}

						@endif
					</div>
					<div class="col-sm-8">
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

						@if(!empty($sermon->audio))
							<button class="btn btn-primary btn-sm play-audio"><i class="fa fa-file-audio-o"></i>
								@lang("Play Audio")
							</button>
						@endif

						@if(!empty($sermon->video))
							<button class="btn btn-danger btn-sm play-video"><i class="fa fa-video-camera"></i>
								@lang("Play Video")
							</button>
						@endif

						<button class="btn btn-success btn-sm sermon-message"><i class="fa fa-eye-open"></i>
							<i class="fa fa-clipboard"></i> @lang("Read Message")
						</button>

					</div>
				</div>
			@endif

		</div>
		<div class="col-sm-3 hidden-xs">
			@include('sermons.recent_sidebar')
		</div>
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