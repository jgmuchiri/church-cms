@extends('layouts.admin-template')
@section('title')
	@lang("Sermons")
@endsection

@section('content')
	<div class="card card-default">
		<div class="card-header">
			<a href="/sermons/admin" class="btn btn-success btn-sm">
				<i class="fa fa-list-alt"></i> @lang("Sermons")
			</a>
			<a href="/sermons/admin/drafts" class="btn btn-inverse btn-sm">
				<i class="fa fa-list-alt"></i> @lang("Drafts")
			</a>
			<a href="/sermons/create" class="btn btn-primary btn-sm">
				<i class="fa fa-plus"></i> @lang("New Sermon")
			</a>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3">
			<div class="list-group">
				<div class="list-group-item">
					<div class="media">
						<div class="align-self-start mr-2">
							{{count($sermons->where('status','published'))}}
						</div>
						<div class="media-body text-truncate">
							<p class="mb-1">
								<a class="text-purple m-0" href="#"> @lang("Published")</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="list-group">
				<div class="list-group-item">
					<div class="media">
						<div class="align-self-start mr-2">
							{{count($sermons->where('status','draft'))}}
						</div>
						<div class="media-body text-truncate">
							<p class="mb-1">
								<a class="text-purple m-0" href="#"> @lang("Draft")</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br/>
	<div class="card card-default">
		<div class="card-body nopadding">
			<table class="table table-striped" id="table-basic">
				<thead>
				<tr>
					<th></th>
					<th>@lang("Published on")</th>
					<th>@lang("Topic")</th>
					<th>@lang("Speaker")</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				@foreach($sermons as $s)
					<tr>
						<td>
							@if($s->audio !==null)
								<i class="fa fa-volume-up"></i>
							@endif
							@if($s->video !==null)
								<i class="fa fa-camera"></i>
							@endif
						</td>

						<td>{{date('d M y',strtotime($s->created_at))}}</td>

						<td><a target="_blank"
							   href="/sermons/{{$s->slug}}">{{$s->title}}</a></td>
						<td>{{$s->speaker}}</td>
						<td>
							<a href="/sermons/{{$s->id}}/edit" class="btn btn-info btn-xs"><i
										class="fa fa-pencil"></i> </a>
							<a href="/sermons/{{$s->id}}/delete" class="btn delete btn-danger btn-xs"><i
										class="fa fa-trash"></i> </a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<div class="text-center">{{$sermons->render()}}</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
        $('.delete').click(function (e) {

            if (confirm('@lang("Are you sure?")')) {
                return true;
            }

            e.preventDefault();
            return false;
        })
	</script>
@endpush