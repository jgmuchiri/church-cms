<table id="table" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </tfoot>
    <tbody>
    @foreach(App\User::get() as $u)
        <tr>
            <td>
                {{Form::checkbox('users[]',$u->id, in_array($u->id,explode(',',$group->users)),['style'=>'width:45px;'])}}
            </td>
            <td>{{$u->first_name.' '.$u->last_name}}</td>
            <td>{{$u->email}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@include('partials.datatables')