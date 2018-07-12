@extends('emails.template')

@section('content')
	{{ $slot }}

	@isset($subcopy)
		{{ $subcopy }}
	@endisset
@endsection
