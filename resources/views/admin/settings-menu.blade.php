<ul style="max-width: 200px;">
    <li class="@if(Request()->segment(1)=="") active @endif">
        <a href="/settings"><i class="icon-th"></i> Settings</a>
    </li>
    <li class="@if(Request()->segment(1)=="gift-options") active @endif">
        <a href="/giving/gift-options">
            <i class="icon-chevron-right"></i> Gift Options </a>
    </li>
    <li class="@if(Request()->segment(1)=="menu") active @endif">
        <a href="/settings/menu">
            <i class="icon-chevron-right"></i> Main menu </a>
    </li>

    <li class="@if(Request()->segment(1)=="themes") active @endif">
        <a href="/settings/themes">
            <i class="icon-chevron-right"></i> Themes </a>
    </li>

    <li class="@if(Request()->segment(1)=="roles") active @endif">
        <a href="/roles">
            <i class="icon-chevron-right"></i> Roles </a>
    </li>

    <li class="@if(Request()->segment(1)=="permissions") active @endif">
        <a href="/permissions">
            <i class="icon-chevron-right"></i> Permissions </a>
    </li>
    {{--<li class="@if(Request()->segment(2)=="seo") active @endif">--}}
    {{--<a href="/settings/seo">--}}
    {{--<i class="icon-chevron-right"></i> SEO </a>--}}
    {{--</li>--}}

    <li class="@if(Request()->segment(2)=="kiosk") active @endif">
        <a href="/kiosk">
            <i class="icon-chevron-right"></i> Kiosk Mode </a>
    </li>
</ul>
