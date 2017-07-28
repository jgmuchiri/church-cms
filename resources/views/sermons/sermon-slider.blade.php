 <br/>
 <div class="bs-example">
    <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-captions" data-slide-to="1" class=""></li>
            <li data-target="#carousel-example-captions" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <?php $count = 0; ?>
            @foreach(App\Models\Sermons::latestSermon(0,8) as $sermon)
                <div class="item {{$count==0?'active':''}}">
                    <img style="width:100%;height:400px" data-src="/uploads/sermons/cover/{{$sermon->cover}}"
                         src="/uploads/sermons/cover/{{$sermon->cover}}">
                    <div class="carousel-caption">
                        <h3><a href="/sermons/{{$sermon->slug}}">{{$sermon->title}}</a></h3>
                        <p>{{str_limit($sermon->desc,100)}}</p>
                    </div>
                </div>
                <?php $count++; ?>
            @endforeach
        </div>
        <a class="left carousel-control" href="#carousel-example-captions" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-captions" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<div class="new-caption-area"></div>
@push('styles')
<style>
    .bs-example, .new-caption-area {
        width: 100%;
        margin: auto;
        color: #000;
    }

    .carousel-caption {
        color: #000;
    }
</style>
@endpush

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