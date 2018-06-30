<div id="users">
    <div class="controls">
        <div class="input-append">
            <input class="search col-sm-11" placeholder="Search"/>
            <span class="sort add-on" data-sort="name"><span class="icon-search"></span> </span></div>
    </div>

    <table id="table" class="display table" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th></th>
            <th>@lang("Name")</th>
            <th>@lang("Email")</th>
        </tr>
        </thead>
        <tbody class="list">
        @foreach(App\User::get() as $u)
            <tr>
                <td>
                    {{Form::checkbox('users[]',$u->id, in_array($u->id,explode(',',$group->users)),['style'=>'width:45px;'])}}
                </td>
                <td class="name">{{$u->first_name.' '.$u->last_name}}</td>
                <td class="email">{{$u->email}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@push('scripts')
<script src="/plugins/listjs/listjs.min.js" type="text/javascript"></script>
<script>
    var options = {
        valueNames: ['name', 'email']
    };
    new List('users', options);
</script>
@endpush