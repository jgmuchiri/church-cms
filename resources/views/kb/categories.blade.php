@extends('layouts.admin-template')
@section('title')
   @lang("Knowledge case categories")
@endsection
@section('content')

    <div class="card card-default">
        <div class="card-header bg_lg"><span class="icon"><i class="icon"></i></span>
            <h5>@lang("Knowledge case categories")</h5>
            <div class="buttons">
                <a href="/support/questions" class="btn btn-info btn-sm">
                    <i class="fa fa-chevron-left"></i> @lang("Back")
                </a>
            </div>
        </div>

        <div class="card-body nopadding">
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-bordered data-table selec2">
                        <tr>
                            <th>@lang("Name")</th>
                            <th>@lang("Description")</th>
                            <th>@lang("Icon")</th>
                            <th>@lang("Order")</th>
                        </tr>
                        @foreach($cats as $cat)
                            <tr>
                                <td><a href="?cat={{$cat->id}}">{{$cat->name}}</a></td>
                                <td>{{$cat->desc}}</td>
                                <td><i style="font-size: 32px;" class="fa {{$cat->icon}}"></i></td>
                                <td>{{$cat->order}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-sm-6">
                    @if(isset($_GET['cat']))

                        <h4 class="title">@lang("Update Category")</h4>
                        <?php
                        $myCat = DB::table('kb_cats')->where('id', $_GET['cat'])->first();
                        $button = "Update";
                        ?>
                        {{Form::model($myCat,['url'=>'support/categories/'.$myCat->id,'method'=>'patch'])}}
                    @else
                        <h4 class="title">@lang("New Category")</h4>
                        {{Form::open(['url'=>'support/categories'])}}
                        <?php $button = "Submit"; ?>
                    @endif

                    <label>@lang("Name")</label>
                    {{Form::text('name',null,['required'=>'required'])}}

                    <label>@lang("Description")</label>
                    {{Form::textarea('desc',null,['rows'=>3])}}

                    <label>@lang("Order")</label>
                    {{Form::input('number','order',null,['class'=>'form-control'])}}

                    <label>@lang("Display icon")</label>
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="icon" class="col-sm-12 select2">
                                @foreach(App\Tools::fa() as $icon)
                                    <option
                                            {{isset($myCat) && ($icon == $myCat->icon)?'selected':''}}
                                            value="{{$icon}}">
                                        <i class="fa {{$icon}}"></i>
                                        {{strtoupper(str_replace('fa-','',$icon))}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <span class="fa fa-show">
                                @if(isset($myCat))
                                    <i class="fa {{$myCat->icon}} fa-4x"></i>
                                @endif
                                </span>
                        </div>
                    </div>

                    <br/>
                    @if(isset($myCat))
                        <a href="/support/categories" class="btn btn-danger">Cancel</a>
                    @endif
                    <button class="btn btn-default">{{$button}}</button>
                    {{Form::close()}}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endpush

@push('scripts')
<script>
    $('.select2').select2();

    $('select[name=icon]').change(function () {
        var icon = $(this).val();
        $('.fa fa-show').html("<i class='fa " + icon + " fa-4x text-info'></i>");
    });
</script>
@endpush