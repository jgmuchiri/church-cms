<div class="row">
	<div class="col-sm-8">
		<div class="card card-default">
			<div class="card-header"><h4>{{$heading}}
					@if(isset($sermon) && $sermon->status =='published')
						<a target="_blank" class="btn btn-link btn-xs pull-right" href="/sermons/{{$sermon->slug}}">@lang('View') <i class="fa fa-external-link"></i> </a>
					@endif
				</h4></div>
		</div>
		<div class="card card-default">
			<div class="card-body">

				{{Form::label('title',__('Title'))}}
				{{Form::text('title',null,['required'=>'required','class'=>'form-control'])}}

				{{Form::label('desc',__('Excerpt'))}}
				{{Form::textarea('desc',null,['placeholder'=>__("Short Description"),'rows'=>3,'class'=>'form-control'])}}
				{{Form::label('message',__('Message'))}}
				{{Form::textarea('message',null,['placeholder'=>__("Message"),'class'=>'editor form-control'])}}


				{{Form::label('video',__('Video'))}}
				{{Form::text('video',null,['class'=>'form-control','placeholder'=>__("Video URL").' (Youtube or Vimeo)'])}}

			</div>
		</div>
	</div>


	<div class="col-sm-4">
		<div class="card card-default">
			<div class="card-body">
				{{Form::label('status',__('Status'))}}
				{{Form::select('status',['draft'=>__("Draft"),'published'=>__("Published")],null,['class'=>'form-control'])}}

				{{Form::label('date',__('Date'))}}
				{{Form::input('date','created_at',date('Y-m-d'),['class'=>'form-control','required'=>'required'])}}

				{{Form::label('topic',__('Topic'))}}
				{{Form::text('topic',null,['class'=>'form-control'])}}

				{{Form::label('sub_topic',__('Sub topic'))}}
				{{Form::text('sub_topic',null,['class'=>'form-control','required'=>'required','placeholder'=>__("Sub Topic")])}}

				{{Form::label('speaker',__('Speaker'))}}
				{{Form::text('speaker',null,['class'=>'form-control','placeholder'=>__("Speaker")])}}

				{{Form::label('scripture',__('Scripture'))}}
				{{Form::text('scripture',null,['class'=>'form-control','placeholder'=>__("Scripture")])}}

				<hr/>
				{{Form::label('audio',__('Upload audio'))}}<em>mp3</em>
				{{Form::file('audio',['class'=>'btn btn-default form-control'])}}


				@if(isset($sermon) && !empty($sermon->audio))
					<audio style="width:100%" src="{{Storage::url($sermon->audio)}}"
						   controls="controls"></audio>
				@endif
				<hr/>

				{{Form::label('cover',__('Cover Image'))}}
				{{Form::file('cover',['class'=>'btn btn-default, form-control'])}}
				@if(isset($sermon) && !empty($sermon->cover))
					<img src="{{Storage::url($sermon->cover)}}"
						 style="width:100px"/>
				@endif


				<hr/>
				<button class="btn btn-default">@lang($btn)</button>
			</div>
		</div>
	</div>
</div>