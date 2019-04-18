@extends('layouts.admin-template')
@section('title')
	Knowledge Base
@endsection
@section('content')
	<div class="row">
		<div class="col-sm-3">
			<div class="card card-default">
				<div class="card-body">
					<ul class="nav nav-pills nav-stacked">
						@foreach($kbCats as $kbCat)
							<li class="nav-item">
								<a href="/support/topic/{{$kbCat->name}}">
									<i class="fa {{$kbCat->icon}}"></i>
									{{$kbCat->name}}</a>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-9">

			<form method="get" action="/support/search"
				  style="padding:10px;border:solid 1px;background:#858894">

				<div class="row">
					<div class="col-sm-11">
						<input type="text"
							   name="s"
							   class="form-control"
							   placeholder="What can we help you with? Enter a search term.">
					</div>
					<div class="col-sm-1">
						<button class="btn btn-inverse"><i class="fa fa-search"></i></button>
					</div>
				</div>

			</form>

			<br/>

			<div class="card">
				<div class="card-body">
					@foreach($kbs as $kb)
						<h4>{{$kb->question}}</h4>
						{!! $kb->question_desc !!}
						<hr/>
					@endforeach

					{!! $kbs->links() !!}
				</div>
			</div>


		</div>
	</div>
@endsection