@extends('layouts.public')

@section('content')
    <section id="layout-content">
        <div class="container">
            <div class="h2 title bg-success">Contact us</div>

            <div class="row">
                <div class="col-md-7">
                    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
                    <div style='overflow:hidden;height:440px;width:100%;'>
                        <div id='gmap_canvas' style='height:440px;width: 100%;'></div>
                    </div>
                    <script type='text/javascript'>function init_map() {
                            var places = [];
                            var geocoder = new google.maps.Geocoder();
                            var address= "{{str_replace(array("\n", "\t", "\r"), ' ',env('ADDRESS'))}}";

                            geocoder.geocode({'address': address}, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    map.setCenter(results[0].geometry.location);
                                    var marker = new google.maps.Marker({
                                        map: map,
                                        position: results[0].geometry.location
                                    });
                                    places.push(results[0].geometry.location);
                                } else {
                                    alert("Geocode was not successful for the following reason: " + status);
                                }
                            });

                            var myOptions = {
                                zoom: 15,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            };
                            map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);

                        }
                        google.maps.event.addDomListener(window, 'load', init_map);
                    </script>
                </div>
                <div class="col-md-5">

                    <p><i class="icon-inbox"></i>{!! env('ADDRESS') !!}</p>

                    <p><i class="icon-phone"></i>{!! env('PHONE')!!}</p>

                    <p><i class="icon-envelope"></i>{!! env('EMAIL_FROM_ADDRESS')!!}</p>
                    <hr/>

                    {!! Form::open(['url'=>"contact"]) !!}
                    <table class="table table-responsive no-border">
                        <tr>
                            <td>Name:</td>
                            <td>{{Form::text('name',null,['required'=>'required','class'=>'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{Form::input('email','email',null,['required'=>'required','class'=>'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td>Subject:</td>
                            <td>{{Form::text('subject',null,['required'=>'required','class'=>'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td>Message:</td>
                            <td>{{Form::textarea('message',null,['required'=>'required','rows'=>3,'class'=>'form-control'])}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button class="btn btn-default"><i class="fa fa-paper-plane-o"></i> Send</button>
                            </td>
                        </tr>
                    </table>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </section>
@endsection