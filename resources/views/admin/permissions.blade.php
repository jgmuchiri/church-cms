@extends('layouts.template')
@section('crumbs')
    <a href="#" class="current">Permissions</a>
@endsection
@section('title')
    Permissions
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span2 btn-icon-pg">
            @include('admin.settings-menu')
        </div>

        <div class="span10">
            <div class="row-fluid">
                <div class="widget-box">
                    <div class="widget-title bg_lg"><span class="icon"><i class="icon-lock"></i></span>
                        <h5>Permissions</h5>
                        <div class="input-group searchForm">
                            <input type="text" id="p-search" name="search" placeholder="Search permissions"/>

                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span8">
                                <div class="ajaxNav">
                                    @include('admin.permissions-ajax')
                                </div>
                            </div>
                            <div class="span4">
                                <i class="icon-plus"></i> Create/Update
                                <a class="btn btn-danger btn-mini pull-right" data-toggle="modal"
                                   data-target="#myModal">
                                    <i class="icon-question-sign"></i>
                                </a>


                                <div class="widget-box">
                                    <div class="widget-title">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#standard">Standard</a></li>
                                            <li><a data-toggle="tab" href="#special">Special</a></li>
                                        </ul>
                                    </div>
                                    <div class="widget-content tab-content">
                                        <div id="standard" class="tab-pane active">
                                            @if(isset($_GET['perm']) && count($my_perm))
                                                {!! Form::model($my_perm,['url'=>'permissions','method'=>'patch']) !!}
                                                {!! Form::hidden('perm_id',$my_perm->id) !!}
                                                <label>Name</label>
                                                {!! Form::text('name',null,['required'=>'required']) !!}
                                                <label>Display Name</label>
                                                {!! Form::text('display_name',null,['required'=>'required']) !!}

                                            @else
                                                {!! Form::open(['url'=>'permissions']) !!}
                                                <label>Module</label>
                                                {!! Form::text('module',null,['required'=>'required']) !!}

                                                <label>Permission</label><br/>
                                                <select name="perms">
                                                    <option value="crud">Create/Read/Update/Delete</option>
                                                    <option value="cru">Create/Read/Update</option>
                                                    <option value="cr">Read/Update</option>
                                                    <option value="r">Read Only</option>
                                                </select>
                                            @endif

                                            <label>Description</label>
                                            {!! Form::textarea('description',null,['rows'=>3]) !!}

                                            <label>Assign to roles</label><br/>
                                            @if(isset($_GET['perm']) && count($my_perm))

                                                <?php
                                                function findPerm($perm, $role)
                                                {
                                                    $perms = DB::table('permission_role')
                                                        ->where('permission_id', $perm)
                                                        ->where('role_id', $role)->first();
                                                    if (count($perms) > 0)
                                                        return true;
                                                    return false;
                                                }
                                                ?>
                                                @foreach(DB::table('roles')->get() as $role)
                                                    {!! Form::checkbox('roles[]',$role->id,findPerm($my_perm->id, $role->id)) !!} {{$role->name}}
                                                    <br/>
                                                @endforeach

                                                <hr/>
                                                <a href="/permissions" class="btn  btn-danger btn-mini">Cancel</a>
                                                <button class="btn  btn-default btn-mini">Update</button>

                                                <p><br/></p>
                                                <a href="/permissions/delete/{{$my_perm->id}}" class="delete"><i
                                                            class="icon-trash"></i>delete
                                                    permission</a>
                                            @else
                                                @foreach(DB::table('roles')->get() as $role)
                                                    {!! Form::checkbox('roles[]',$role->id,false) !!} {{$role->name}}
                                                    <br/>
                                                @endforeach

                                                <hr/>
                                                <button class="btn  btn-default btn-mini">Create</button>
                                            @endif

                                            {!! Form::close() !!}
                                        </div>
                                        <div id="special" class="tab-pane">
                                            {!! Form::open(['url'=>'permissions']) !!}
                                            {!! Form::hidden('special',1) !!}
                                            <label>Role</label>
                                            {!! Form::text('name',null,['required'=>'required']) !!}

                                            <label>Display Name</label>
                                            {!! Form::text('display_name',null,['required'=>'required']) !!}

                                            <label>Description</label>
                                            {!! Form::textarea('description',null,['rows'=>3]) !!}

                                            <label>Assign to roles</label><br/>
                                            @foreach(DB::table('roles')->get() as $role)
                                                {!! Form::checkbox('roles[]',$role->id,false) !!} {{$role->name}}
                                                <br/>
                                            @endforeach

                                            <hr/>
                                            <button class="btn  btn-default btn-mini">Create</button>

                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
<link rel="stylesheet" type="text/css" href="/plugins/tokeninput/css/token-input.css"/>
<link rel="stylesheet" type="text/css" href="/plugins/tokeninput/css/token-input-facebook.css"/>
<script type="text/javascript" src="/plugins/tokeninput/js/jquery.tokeninput.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#roles").tokenInput("/roles/getRoles", {
            method: "GET",
            queryParam: "q",
            searchDelay: 300,
            minChars: 1,
            propertyToSearch: "name",
            contentType: "json",
            excludeCurrent: true,
            placeholder: "Search for user",
            resultsLimit: 10
        });

        $(document).on('click', '.pagination li a', function (e) {
            var page = $(this).attr('href').split('page=')[1];
            $.ajax({
                url: '?page=' + page,
                dataType: 'json',
            }).done(function (data) {
                $('.ajaxNav').html(data);
            }).fail(function () {
                alert('Data could not be loaded.');
            });
            e.preventDefault();
        });
        $('#p-search').on('keyup', function (e) {
            var key = $(this).val();
            $.ajax({
                url: '/permissions/search/' + key,
                dataType: 'json',
                data: {_token: '{{csrf_token()}}'},
                type: 'post'
            }).done(function (data) {
                $('.ajaxNav').html(data);
            }).fail(function () {
                $('.ajaxNav').html('<div class="alert alert-danger">No data found</div>');
            });
            e.preventDefault();
        });

    });
</script>
@endpush
@include('partials.datatables',['table'=>'#table'])
@push('modals')
<div class="modal hide" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Permissions Notice</h4>
            </div>
            <div class="modal-body">
                                             <span class=" text-sm">
                        Only add a permission that the system recognizes. This can be determined if a user reports
                        that they got an error stating "You are not authorized to <em class="label label-danger">action
                                                     module (e.g. delete users)
                                                 </em>". Add the
                        <em class="label label-danger">module</em> and assign it to the role the user belongs to. Otherwise, you can create a special role
                        for that user if you do not want to give access to others users with the same role.</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                </button>
            </div>
        </div>
    </div>
</div>
@endpush
