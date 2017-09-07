<h4 class="">@lang("Recent sermons")</h4>
<?php
$rSermons = App\Models\Sermons::simplePaginate(10);
?>
<ul class="nav nav-list">
    @foreach($rSermons as $s)
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-4">
                    @if(is_file('uploads/sermons/cover/'.$s->cover))
                        <img style="heigth:42px;width:60px;" src="/uploads/sermons/cover/{{$s->cover}}"/>
                    @else
                        {!! App\Tools::postThumb('none','42px','60px') !!}
                    @endif
                </div>
                <div class="col-md-8">
                    <a href="/sermons/{{$s->slug}}" style="font-size:12px">{{$s->title}}</a></div>
            </div>
            <div class="row">
                <div class="col-md-6"><em style="font-size: 11px;">@lang("by") {{$s->speaker}}</em></div>
                <div class="col-md-6"><em style="font-size: 11px;">{{date('d M, Y',strtotime($s->created_at))}}</em>
                </div>
            </div>
        </li>
    @endforeach
</ul>

<div class="text-center">{{$rSermons->render()}}</div>