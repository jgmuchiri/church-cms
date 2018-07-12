<div class="row">

	<div class="col-sm-8">
		<div class="card card-default">
			<div class="card-body">
				{{Form::label('title',__('Title'))}}
				{{Form::text('title',null,['required'=>'required','class'=>'form-control'])}}

				{{Form::label('body',__('Body'))}}
				{{Form::textarea('body',null,['class'=>'editor form-control'])}}
			</div>

		</div>
	</div>
	<div class="col-sm-4">
		<div class="card card-default">
			<div class="card-body">
				{{Form::label('published_at',__('Publish data'))}}
				{{Form::input('date','published_at',date('Y-m-d'),['required'=>'required','class'=>'form-control'])}}

				{{Form::label('status',__('Status'))}}
				{{Form::select('status',['draft'=>'Draft','published'=>'Published'],null,['class'=>'form-control'])}}

				{{Form::label('blog_cats',__('Categories'))}}
                <?php $cats = DB::table('blog_cats')->get(); ?>
				@foreach ($cats as $cat)<br/>
				{{Form::checkbox('categories[]',$cat->id,false,['style'=>'width:20px;'])}}{{$cat->name}}
				<br/>
				@endforeach
				<br/>
				<button class="btn btn-inverse">@lang("Submit")</button>
			</div>
		</div>
	</div>
</div>