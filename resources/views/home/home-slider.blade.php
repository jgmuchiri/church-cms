@if(sizeof($slides)>0)
	<section class="section-container">
		<!-- Page content-->
		<div class="content-wrapper">
			<div class="carousel" id="homeSliders" data-ride="carousel">
				<ol class="carousel-indicators">
					<li class="active" data-target="#homeSliders" data-slide-to="0"></li>
					<li data-target="#homeSliders" data-slide-to="1"></li>
					<li data-target="#homeSliders" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">

                    <?php $count = 0; ?>
					@foreach($slides as $slide)
						<div class="carousel-item {{$count==0?'active':''}}">
							<img class="d-block w-100"
								 style="width:100%;height:400px"
								 alt="{{$slide->title}}"
								 src="{{Storage::url($slide->img)}}">
							<div class="carousel-caption d-none d-md-block">
								<h5><a href="{{url()->to($slide->url)}}">{{$slide->title}}</a></h5>
								<p>{{str_limit($slide->desc,100)}}</p>
							</div>
						</div>
                        <?php $count++; ?>
					@endforeach
				</div>
				<a class="carousel-control-prev" href="#homeSliders" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#homeSliders" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</section>
@endif

@push('scripts')
	<script>
        jQuery(function ($) {
            $('.carousel').carousel();
            var caption = $('div.item:nth-child(1) .carousel-caption');
            $('.new-caption-area').html(caption.html());
            caption.css('display', 'none');

            $(".carousel").on('slide.bs.carousel', function (evt) {
                var caption = $('div.item:nth-child(' + ($(evt.relatedTarget).index() + 1) + ') .carousel-caption');
                $('.new-caption-area').html(caption.html());
                caption.css('display', 'none');
            });
        });
	</script>
@endpush