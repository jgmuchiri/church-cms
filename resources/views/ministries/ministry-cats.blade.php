<ul class="nav nav-stacked nav-pills">
    <li class="@if(!isset($_GET['cat'])) active @endif">
        <a href="/ministries"><i class="icon-th"></i> @lang("All Ministries")</a>
    </li>
    @foreach($categories as $c)
        <li class="@if((isset($_GET['cat']) && $c->slug==$_GET['cat'])) active @endif">
            <a href="/ministries?cat={{$c->slug}}">
                <i class="icon-chevron-right"></i> {{ucwords($c->name)}} </a>
        </li>
    @endforeach
</ul>