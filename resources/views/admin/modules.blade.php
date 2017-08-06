<input class="search form-control input-sm" placeholder="Search"/><br/>
<ul class="list nav nav-pills nav-stacked">
    @foreach($modules as $module)
        <li id="{{$module->id}}" class="module">
            <a href="#" class="name">{{ucwords($module->name)}}
                <span class="pull-right"><i class="fa fa-chevron-right" style="display: none;"></i> </span>
            </a>
        </li>
    @endforeach
</ul>
<ul class="pagination"></ul>