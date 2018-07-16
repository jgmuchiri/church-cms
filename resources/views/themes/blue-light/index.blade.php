@push('styles')
<link rel="stylesheet" href="/themes/{{theme('location')}}/css/style.css">
@endpush

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <a href="{{url()->to('/')}}">
                        <img style="height: 21px;" src="/img/logo.png">
                    </a>
                </h1>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="fa fa-bar"></span>
                    <span class="fa fa-bar"></span>
                    <span class="fa fa-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {!! theme()->menu(['icons']) !!}
                </ul>
            </div>
        </div>
    </nav>

    <section class="container content">
        <h4>@yield('title')</h4>
        @yield('content')
    </section>

@endsection


@section('footer')
    <div class="container">
        <footer id="footer">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="logo">
                        <a href="/">{{config('app.name')}}
                        </a>
                    </h1>
                </div>
                <div class="col-md-4">
                    <div class="socials">
                        <a href="{{config('app.social.twitter')}}" class="fa fa-twitter"></a>
                        <a href="{{config('app.social.facebook')}}" class="fa fa-facebook"></a>
                        <a href="{{config('app.social.google')}}" class="fa fa-google-plus"></a>
                        <a href="{{config('app.social.pinterest')}}" class="fa fa-pinterest"></a>
                        <a href="{{config('app.social.linkedin')}}" class="fa fa-linkedin"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="sub-copy">&copy; <span id="copyright-year"></span>| <a href="#">Privacy Policy</a> <br>
                        Template designed by <a href="http://amdtllc.com/" rel="nofollow">amdtllc.com</a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </footer>
    </div>
@endsection