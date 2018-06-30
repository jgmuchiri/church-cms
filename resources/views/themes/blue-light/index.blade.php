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
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
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
                        <a href="/">{{env('APP_NAME')}}
                        </a>
                    </h1>
                </div>
                <div class="col-md-4">
                    <div class="socials">
                        <a href="{{env('TWITTER_URL')}}" class="icon-twitter"></a>
                        <a href="{{env('FB_URL')}}" class="icon-facebook"></a>
                        <a href="{{env('GOOGLE_PLUS_URL')}}" class="icon-google-plus"></a>
                        <a href="{{env('PINTREST_URL')}}" class="icon-pinterest"></a>
                        <a href="{{env('LINKEDIN_URL')}}" class="icon-linkedin"></a>
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