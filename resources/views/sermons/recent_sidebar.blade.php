<h4 class="">@lang("Recent sermons")</h4>
<?php
$rSermons = App\Models\Sermons::simplePaginate(10);
?>
<ul class="nav nav-list list-group">
	@foreach($rSermons as $s)
		<li class="list-group-item">
			<a href="/sermons/{{$s->slug}}" style="font-size:12px">{{$s->title}}</a>
		</li>
	@endforeach
</ul>

<div class="text-center">{{$rSermons->render()}}</div>