<h3>@lang($heading)</h3>
{{Form::label('name',__('Name'))}}
{{Form::text('name',null,['required'=>'required','class'=>'form-control'])}}

{{Form::label('desc',__('Description'))}}<em>(@lang("this will show on top of ministry page")</em></label>
{{Form::textarea('desc',null,['class'=>'form-control','rows'=>3])}}
<br/>
<br/>

<button class="btn btn-default">@lang($btn)</button>

@if(isset($close))
	<a href="/ministries/categories" class="btn btn-danger pull-right">@lang("Close")</a>
@endif