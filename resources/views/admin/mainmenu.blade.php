@extends('layouts.admin-template')
@section('title')
	@lang("Main Menu")
@endsection
@section('crumbs')
	<a href="#" class="current">@lang("main menu")</a>
@endsection

@section('content')
	<div class="row">
		@include('admin.settings-menu')

		<div class="col-sm-9">
			<div class="card card-default no-top">
				<div class="card-header">
					<div class="card-title"><h4>@lang("Main menu")</h4></div>
				</div>
				<div class="card-body">
					<div class="blockquote">
						@lang("Main menu notice",['text'=>'<code>no-submenu</code>'])
					</div>

					<div class="row">
						<div class="col-sm-4">
							@if(sizeof($menuItem)>0)
								<h4>@lang("Edit Menu Item")</h4>
								{{Form::model($menuItem,['url'=>'menu/','method'=>'patch'])}}
								{{Form::hidden('id',$menuItem->id)}}
								<label>@lang("Title")</label>
								{{Form::text('title',null,['required'=>'required','class'=>'form-control'])}}
								<label>@lang("Path")</label>
								{{Form::text('path',null,['required'=>'required','class'=>'form-control','placeholder'=>'e.g. /home'])}}
								<label>@lang("Parent")</label>
								{!! Form::select('parent',$items,$menuItem->parent,['class'=>'form-control']) !!}
								<br/>

								<label>@lang("Order")</label>
								{{Form::text('order',null,['required'=>'required','class'=>'form-control'])}}
								<label>@lang("Icon")</label>
								<div class="controls">
									<div class="input-group">
										<select name="icon" class="select2 form-control">
											@foreach(\App\Tools::fa() as $f)
												<option value="{{$f}}">fa-{{$f}}</option>
											@endforeach
										</select>

										<span class="addon col-sm-1">
                                            <i id="fa-icon"
											   class="@if(!empty($menuItem->icon))fa fa-{{$menuItem->icon}} @endif"></i>
                                        </span>
									</div>
								</div>
								<br/>
								{{Form::select('active',['1'=>'active','0'=>'disabled'],null,['class'=>'form-control'])}}
								<br/>

								<button class="btn btn-inverse"><i class="fa fa-save"></i> @lang("Save")</button>
								<a href="/menu" class="btn btn-danger right"><i class="fa fa-eye-close"></i>
									@lang("Close")</a>

								{{Form::close()}}

							@else
								<h4>@lang("New Menu Item")</h4>
								{{Form::open(['url'=>'menu'])}}
								<label>@lang("Title")</label>
								{{Form::text('title',null,['required'=>'required','class'=>'form-control'])}}
								<label>@lang("Path")</label>
								{{Form::text('path',null,['required'=>'required','class'=>'form-control','placeholder'=>'e.g. /home'])}}
								<label>@lang("Parent")</label>
								<select name="parent" class="select2 form-control">
									<option value="0">--@lang('None')--</option>
									@foreach($menu as $p)
										<option value="{{$p->id}}">{{$p->title}}</option>
									@endforeach
								</select>
								<br/>

								<label>@lang("Order")</label>
								{{Form::text('order',null,['class'=>'form-control','required'=>'required'])}}
								<label>@lang("Icon")</label>
								<div class="controls">
									<div class="input-group">
										<select name="icon" class="select2 form-control">
											@foreach(\App\Tools::fa() as $f)
												<option value="{{$f}}">fa-{{$f}}</option>
											@endforeach
										</select>

										<span class="addon col-sm-1">
                                            <i id="fa-icon"></i>
                                        </span>
									</div>

								</div>
								<br/>
								{{Form::select('active',['1'=>__('Active'),'0'=>__('Disabled')],null,['class'=>'form-control'])}}

								<br/>
								<button class="btn btn-inverse">@lang("Save")</button>

								{{Form::close()}}
							@endif
							<hr/>
							<h4>@lang("Default menu")</h4>

							<code>/home</code><br/>
							<code>/sermons</code><br/>
							<code>/events</code><br/>
							<code>/ministries</code><br/>
							<code>/blog</code><br/>
							<code>/contact</code><br/>
							<code>/account</code><br/>
							<code>/login</code>

						</div>
						<div class="col-sm-8">
							<table class="table table-striped my-4 w-100">
								<thead>
								<tr>
									<th>@lang("Menu")</th>
									<th>@lang("Order")</th>
									<th>@lang("Icon")</th>
									<th>@lang("Status")</th>
									<th></th>
								</tr>
								</thead>
								<tbody class="sortable-rows">
								@foreach($mainMenu as $m)
									<tr class="sortable-row" id="{{$m->id}}">
										<td>
											<a href="?m={{$m->id}}">{{$m->title}}</a>
										</td>
										<td>{{$m->order}}</td>
										<td><i class="fa fa-{{$m->icon}}"></i></td>
										<td>{!!($m->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
										<td>
											<a href="/menu/delete/{{$m->id}}"></a>
										</td>
									</tr>
									@foreach($subMenu as $s)

										@if($m->id == $s->parent)
											<tr class="bg-info">
												<td style="text-indent: 25px;">
													<a href="?m={{$s->id}}">{{$s->title}}</a>
												</td>
												<td>{{$s->order}}</td>
												<td><i class="fa fa-{{$s->icon}}"></i></td>
												<td>{!!($s->active==1)?'<span class="label label-success">active</span>':'<span class="label label-danger">disabled</span>'!!}</td>
												<td>
													<a href="/menu/delete/{{$s->id}}"></a>
												</td>
											</tr>
										@endif

									@endforeach
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@include('partials.select2',['select2'=>'.select2'])
@push('styles')
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endpush

@push('scripts')

	<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script>
        $('select[name=icon]').on('change', function () {
            var fa = $(this).val();
            $('#fa-icon').attr('class', 'fa fa-' + fa);
        })
        $(function () {
            $(".sortable-rows").sortable({
                placeholder: "ui-state-highlight",
                update: function (event, ui) {
                    updateDisplayOrder();
                }
            });
        });

        // function to save display sort order
        function updateDisplayOrder() {
            var selectedLanguage = [];
            $('.sortable-rows .sortable-row').each(function () {
                selectedLanguage.push($(this).attr("id"));
            });
            var dataString = 'sort_order=' + selectedLanguage + '&_token={{csrf_token()}}';

            $.ajax({
                type: "POST",
                url: "/menu/sort",
                data: dataString,
                cache: false,
                success: function (data) {
                }
            });
        }
	</script>
@endpush