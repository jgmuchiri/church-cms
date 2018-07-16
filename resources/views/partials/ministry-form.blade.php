{{Form::label('name',__('Name'))}}
{{Form::text('name',null,['required'=>'','class'=>'form-control'])}}
<br/>

{{Form::label('cat',__('Categories'))}}
{{Form::select('category_id',\App\Models\Ministry\MinistryCats::pluck('name','id'),null,['class'=>'form-control'])}}
<br/>

{{Form::label('status',__('Status'))}}
{{Form::select('active',['1'=>__("Posted"),'0'=>__("Draft")],null,['class'=>'form-control'])}}
<br/>

{{Form::label('desc',__('Description'))}}
{{Form::textarea('desc',null,['required'=>'','class'=>'form-control'])}}

<br/>
<button class="btn btn-inverse">
	<i class="fa fa-save"></i> @lang($type)</button>