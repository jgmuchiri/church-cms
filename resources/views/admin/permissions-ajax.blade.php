<table class="table table-striped table-full-width table-responsive" id="">
    <thead>
    <tr>
        <th>@lang("Name")</th>
        <th>@lang("Permissions")</th>
        <th>@lang("Description")</th>
    </tr>
    </thead>
    <tbody>
    @foreach($permissions as $perm)
        <tr>
            <td>
                <a href="?perm={{$perm->id}}">{{$perm->name}}</a>
            </td>
            <td onclick="window.location.href='?perm={{$perm->id}}'">
                {{$perm->display_name}}
            </td>
            <td>{{$perm->description}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
{!! $permissions->links() !!}