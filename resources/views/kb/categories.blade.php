@extends('layouts.template')
@section('title')
    Knowledge Base Categories
@endsection
@section('content')

    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon"></i></span>
            <h5>Knowledge case categories</h5>
            <div class="buttons">
                <a href="/support/questions" class="btn btn-info btn-mini">
                    <i class="icon-chevron-left"></i> Back
                </a>
            </div>
        </div>

        <div class="widget-content nopadding">
            <div class="row-fluid">
                <div class="span6">
                    <table class="table table-bordered data-table selec2">
                        <tr>
                            <th>Name</th>
                            <th>Desc</th>
                            <th>Icon</th>
                            <th>Order</th>
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
                <div class="span6">
                    @if(isset($_GET['cat']))

                        <h4 class="title">Update Category</h4>
                        <?php
                        $myCat = DB::table('kb_cats')->where('id', $_GET['cat'])->first();
                        $button = "Update";
                        ?>
                        {{Form::model($myCat,['url'=>'support/categories/'.$myCat->id,'method'=>'patch'])}}
                    @else
                        <h4 class="title">New Category</h4>
                        {{Form::open(['url'=>'support/categories'])}}
                        <?php $button = "Submit"; ?>
                    @endif

                    <label>Name</label>
                    {{Form::text('name',null,['required'=>'required'])}}

                    <label>Desc</label>
                    {{Form::textarea('desc',null,['rows'=>3])}}

                    <label>Order</label>
                    {{Form::input('number','order',null,['class'=>'form-control'])}}

                    <label>Display icon</label>
                    <div class="row-fluid">
                        <div class="span4">
                            <select name="icon" class="span12 select2">
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
                        <div class="span2">
                            <span class="icon-show">
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
        $('.icon-show').html("<i class='fa " + icon + " fa-4x text-info'></i>");
    });
</script>
@endpush