@extends('layouts.admin-template')
@section('title')
	@lang("Blog admin")
@endsection

@section('content')
	<div class="card card-default">
		<div class="card-header bg_lg">

			<div class="buttons">
				<a href="/blog" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> @lang("Blog Homepage")</a>
				<a href="/blog/categories" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>
					@lang('Categories')</a>
				<a href="/blog/create" class="btn btn-inverse btn-sm"><i class="fa fa-plus"></i>
					@lang("New Post")</a>
			</div>
		</div>
		<div class="card-body">

			<span class="label label-default">{{!empty($blog->where('status','published'))}}</span>
			@lang('Published')

			<span class="label label-default">
				{{!empty($blog->where('status','draft'))}}</span> @lang('Draft')

			<hr/>
			<form class="form-inline" method="get">
                    <span class="input-addon">
                         @if(isset($_GET['s']))
							<a href="/blog/admin" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>
                    </a>
						@endif
                    </span>
				<input type="text" name="s" placeholder="Search by ID or Name" class="form-control"/>
				<button class="btn btn-inverse"><i class="fa fa-search"></i></button>
			</form>

			@if(sizeof($blog)>0)
				<table class="table table-striped">
					<thead>
					<tr>
						<th>@lang("Date")</th>
						<th>@lang("Title")</th>
						<th>@lang("Body")</th>
						<th>@lang("Posted by")</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach($blog as $n)
						<tr>
							<td>
								@if($n->status == 'draft')
									<i class="fa fa-times-circle text-danger"></i>
								@else
									<i class="fa fa-check text-success"></i>
								@endif
								{{date('d M y',strtotime($n->created_at))}}

							</td>
							<td><a target="_blank" href="/blog/{{$n->id}}">{{$n->title}}</a></td>
							<td>{!! str_limit(strip_tags($n->body),20,'...') !!}</td>
							<td>
                                <?php $user = App\User::find($n->user_id); ?>
								@if(sizeof($user)>0)
									{{$user->last_name}}
								@endif
							</td>
							<td>
								<a href="/blog/{{$n->id}}/edit" class="btn btn-info btn-sm edit"><i
											class="fa fa-pencil"></i></a>

								<a href="/blog/{{$n->id}}/delete" class="btn btn-danger btn-sm delete"><i
											class="fa fa-trash"></i></a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>

				<div class="text-center">{{$blog->render()}}</div>
			@else
				<hr/>
				<div class="alert alert-danger">@lang("No records found")</div>
			@endif
		</div>
	</div>

@endsection
@push('scripts')
	<script>
        $('.delete').click(function (e) {
            if (confirm('Are you sure?')) {
                return true;
            }
            e.preventDefault();
            return false;
        })
	</script>
@endpush