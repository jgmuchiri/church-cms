<a href="#" id="invert_selection"><i class="fa fa-check"></i> @lang("Inverse selection")</a>
{!! Form::open(['url'=>'update-role-permissions','class'=>'permissions']) !!}
@foreach($rolePerms as $rp)
    <input type="checkbox" @if($rp['selected'] == true) checked @endif name="permissions[]"
           value="{{$rp['level']}}"> {{ucwords($rp['level'])}} <br/>
@endforeach
<br/>
<button class="btn btn-default btn-sm">@lang("Update")</button>
{!! Form::close() !!}