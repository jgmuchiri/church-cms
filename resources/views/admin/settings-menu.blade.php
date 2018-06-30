<div class="col-xl-3 btn-icon-pg card card-default">
	<ul style="max-width: 200px;">
		<li class="@if(Request()->segment(1)=="") active @endif">
			<a href="/settings"><i class="icon-th"></i> Settings</a>
		</li>
		<li class="@if(Request()->segment(1)=="gift-options") active @endif">
			<a href="/giving/gift-options">
				<i class="icon-chevron-right"></i> @lang("Gift Options") </a>
		</li>
		<li class="@if(Request()->segment(1)=="menu") active @endif">
			<a href="/menu">
				<i class="icon-chevron-right"></i> @lang("Main Menu") </a>
		</li>

		<li class="@if(Request()->segment(1)=="themes") active @endif">
			<a href="/theme">
				<i class="icon-chevron-right"></i> @lang("Theme") </a>
		</li>

		<li class="@if(Request()->segment(1)=="roles") active @endif">
			<a href="/roles">
				<i class="icon-chevron-right"></i> @lang("Roles") </a>
		</li>

		{{--<li class="@if(Request()->segment(2)=="seo") active @endif">--}}
		{{--<a href="/settings/seo">--}}
		{{--<i class="icon-chevron-right"></i> @lang("SEO") </a>--}}
		{{--</li>--}}

		<li class="@if(Request()->segment(2)=="debug") active @endif">
			<a href="/debug-log">
				<i class="icon-chevron-right"></i> @lang("Debug Log") </a>
		</li>
		<li class="@if(Request()->segment(2)=="kiosk") active @endif">
			<a href="/kiosk">
				<i class="icon-chevron-right"></i> @lang("Kiosk Mode") </a>
		</li>
	</ul>
</div>