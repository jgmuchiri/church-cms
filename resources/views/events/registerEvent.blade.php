@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">
                <div class="header">

                    <a class="btn btn-default btn-mini" href="/events"><i
                                class="icon-chevron-left"></i>
                        back to events</a>

                </div>
                <div class="content">
                        <iframe id="ifm" src="{{$event->form_id}}" frameborder="0" allowfullscreen align="center" style="width:100%"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        var buffer = 20; //scroll bar buffer
        var iframe = document.getElementById('ifm');

        function pageY(elem) {
            return elem.offsetParent ? (elem.offsetTop + pageY(elem.offsetParent)) : elem.offsetTop;
        }

        function resizeIframe() {
            var height = document.documentElement.clientHeight;
            height -= pageY(document.getElementById('ifm'))+ buffer ;
            height = (height < 0) ? 0 : height;
            document.getElementById('ifm').style.height = height + 'px';
        }

        // .onload doesn't work with IE8 and older.
        if (iframe.attachEvent) {
            iframe.attachEvent("onload", resizeIframe);
        } else {
            iframe.onload=resizeIframe;
        }

        window.onresize = resizeIframe;
    </script>
    @endpush