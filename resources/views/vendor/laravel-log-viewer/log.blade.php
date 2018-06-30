@extends('layouts.admin-template')
@section('title')
	@lang('Debug log')
@endsection
@section('content')
	<div class="card card-default">
		<div class="card-body">
			<div class="row">
				<div class="col sidebar mb-3">
					<div class="list-group">
						@foreach($files as $file)
							<a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
							   class="list-group-item @if ($current_file == $file) llv-active @endif">
								{{$file}}
							</a>
						@endforeach
					</div>
				</div>
				<div class="col-10 table-container">
					@if ($logs === null)
						<div>
							Log file >50M, please download it.
						</div>
					@else
						<table id="table-log" class="table table-striped"
							   data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
							<thead>
							<tr>
								@if ($standardFormat)
									<th>Level</th>
									<th>Context</th>
									<th>Date</th>
								@else
									<th>Line number</th>
								@endif
								<th>Content</th>
							</tr>
							</thead>
							<tbody>

							@foreach($logs as $key => $log)
								<tr data-display="stack{{{$key}}}">
									@if ($standardFormat)
										<td class="text-{{{$log['level_class']}}}"><span
													class="fa fa-{{{$log['level_img']}}}"
													aria-hidden="true"></span>
											&nbsp;{{$log['level']}}</td>
										<td class="text">{{$log['context']}}</td>
									@endif
									<td class="date">{{{$log['date']}}}</td>
									<td class="text">
										@if ($log['stack'])
											<button type="button"
													class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
													data-display="stack{{{$key}}}"><span
														class="fa fa-search"></span></button>@endif
										{{{$log['text']}}}
										@if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif
										@if ($log['stack'])
											<div class="stack" id="stack{{{$key}}}"
												 style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
											</div>@endif
									</td>
								</tr>
							@endforeach

							</tbody>
						</table>
					@endif
				</div>
			</div>
		</div>
		<div class="card-footer">
			@if($current_file)
				<a class="btn btn-primary" href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}">
					<span class="fa fa-download"></span>@lang('Download file')</a>

				<a id="delete-log" class="btn btn-warning"
				   href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}"><span
							class="fa fa-trash"></span> @lang('Delete file')</a>
				@if(count($files) > 1)

					<a class="btn btn-danger" id="delete-all-log" href="?delall=true"><span class="fa fa-trash"></span>
						@lang('Delete all files') </a>
				@endif
			@endif
		</div>
	</div>
@endsection
@push('styles')
	<style>

		#table-log {
			font-size: 0.85rem;
		}

		.sidebar {
			font-size: 0.85rem;
			line-height: 1;
		}

		.btn {
			font-size: 0.7rem;
		}

		.stack {
			font-size: 0.85em;
		}

		.date {
			min-width: 75px;
		}

		.text {
			word-break: break-all;
		}

		a.llv-active {
			z-index: 2;
			background-color: #f5f5f5;
			border-color: #777;
		}

		.list-group-item {
			word-wrap: break-word;
		}
	</style>
@endpush
@include('partials.datatables')
@push('scripts')
	<script>
        $(document).ready(function () {
            $('.table-container tr').on('click', function () {
                $('#' + $(this).data('display')).toggle();
            });
            $('#table-log').DataTable({
                "order": [$('#table-log').data('orderingIndex'), 'desc'],
                "stateSave": true,
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    let data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                }
            });
            $('#delete-log, #delete-all-log').click(function () {
                return confirm('@lang('Are you sure?')')
            });
        });
	</script>
@endpush
