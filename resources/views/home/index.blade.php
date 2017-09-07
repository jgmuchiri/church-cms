@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                @if(count($slides))
                    @include('home.home-slider')
                @else
                    @include('sermons.sermon-slider')
                @endif
            </div>

            <div class="col-md-4 col-sm-3">
                <div class="thumbnail text-center">
                    <br/>
                    <i class="icon-calendar icon-4x text-warning"></i>

                    <div id="caption">
                        <h3>@lang("Regular Schedule")</h3>
                        <table class="table table-responsive text-left">
                            @foreach($churchSchedule as $schedule)
                                <tr>
                                    <td><i class="icon-clock-o"></i>
                                        {{date('H:ia',strtotime($schedule->start)).'- '.date('H:ia',strtotime($schedule->end))}}
                                    </td>
                                    <td>{{$schedule->event}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <br/>

                        <p>
                            <a href="/events" class="btn btn-lg btn-warning nav-item" role="button">@lang("Calendar")</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="layout-content">
        <div id="features"></div>
        <div class="container">
            <h3 class="text-center text-success"></h3>

            <div class="row">
                <div class="col-md-4">
                    <h3>@lang("Latest articles")</h3>
                    @foreach($blogs as $blog)
                        <a href="/blog/{{$blog->id}}">{{$blog->title}}</a><br/>
                    @endforeach
                    <a href="/blog" class="link">@lang("more")...</a>
                </div>

                <div class="col-md-4">
                    <h3>@lang("Ministries")</h3>
                    @foreach($ministries as $min)
                        <a href="/ministries/{{$min->slug}}">{{$min->name}}</a>
                        <br/>
                    @endforeach
                    <a href="/ministries" class="link">@lang("more")...</a>
                </div>

                <div class="col-md-4">
                    <h3>@lang("Events")</h3>
                    @foreach($events as $event)
                        <a href="/events/{{$event->id}}">{{$event->title}}</a>
                        <br/>
                    @endforeach
                    <a href="/events" class="link">@lang("more")...</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $('.form').submit(function (e) {
        e.preventDefault();
        var m = $(this).find('input[name=s]').val();
        window.location.href = '/m/' + m;
    })
</script>
@endpush
