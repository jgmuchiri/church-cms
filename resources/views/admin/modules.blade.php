<input class="search form-control input-sm" placeholder="Search"/><br/>
<ul class="list nav nav-pills nav-stacked dd-list">
    @foreach($modules as $module)
        <li class="dd-item module" id="{{$module->id}}">
            <a href="#" class="name text-success">{{ucwords($module->name)}}
                <span class="pull-right"><i class="fa fa-chevron-right" style="display: none;color:green"></i> </span>
            </a>
        </li>
    @endforeach
</ul>
<ul class="pagination"></ul>