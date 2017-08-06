<div class="span2 btn-icon-pg">
    <ul style="max-width: 200px;">
        <li class="@if(Request()->segment(1)=="") active @endif">
            <a href="/settings"><i class="icon-th"></i> Settings</a>
        </li>
        <li class="@if(Request()->segment(1)=="gift-options") active @endif">
            <a href="/giving/gift-options">
                <i class="icon-chevron-right"></i> Gift Options </a>
        </li>
        <li class="@if(Request()->segment(1)=="menu") active @endif">
            <a href="/menu">
                <i class="icon-chevron-right"></i> Main Menu </a>
        </li>

        <li class="@if(Request()->segment(1)=="themes") active @endif">
            <a href="/theme">
                <i class="icon-chevron-right"></i> Theme </a>
        </li>

        <li class="@if(Request()->segment(1)=="roles") active @endif">
            <a href="/roles">
                <i class="icon-chevron-right"></i> Roles </a>
        </li>

        {{--<li class="@if(Request()->segment(2)=="seo") active @endif">--}}
        {{--<a href="/settings/seo">--}}
        {{--<i class="icon-chevron-right"></i> SEO </a>--}}
        {{--</li>--}}

        <li class="@if(Request()->segment(2)=="debug") active @endif">
            <a href="/debug-log">
                <i class="icon-chevron-right"></i> Debug Log </a>
        </li>
        <li class="@if(Request()->segment(2)=="kiosk") active @endif">
            <a href="/kiosk">
                <i class="icon-chevron-right"></i> Kiosk Mode </a>
        </li>
    </ul>
</div>