@if(is_null(theme('location')))
@include('themes.default.index')
@else
@include('themes.'.theme('location').'.index')
@endif
