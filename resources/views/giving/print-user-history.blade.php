<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>{{env('APP_NAME')}}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>

    <link href="/css/admin.css" rel="stylesheet"/>
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

    <style>
        [class^="icon-"], [class*=" icon-"] {
            margin-left: 4px;
            margin-right: 4px;
        }

        table td:first-child {
            text-align: left;
        }

        body {
            background: #fff;
            margin-top:10px;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="table">
        <tr>
            <td>
                <table class="no-border">
                    <tr>
                        <td><span class="icon-user"></span></td>
                        <td><strong> {{Auth::user()->first_name.' '.Auth::user()->last_name}}</strong></td>
                    </tr>
                    <tr>
                        <td><span class="icon-inbox"></span></td>
                        <td>{!! Auth::user()->address !!}</td>
                    </tr>
                    <tr>
                        <td><span class="icon-phone"></span></td>
                        <td>{{Auth::user()->phone}}</td>
                    </tr>
                </table>

            </td>
            <td class="text-center">

                <h2>{{$_GET['y']}}</h2>
                <h3>Yearly Contributions</h3>
            </td>
            <td>
                <img class="thumbnail" src="/images/admin-logo.png" style="background:#333;padding:10px;"/>
                <h4 class="title">{{env('APP_NAME')}}</h4>
                <table class="no-border">
                    <tr>
                        <td><span class="icon-inbox"></span></td>
                        <td valign="top">{!!env('ADDRESS') !!}</td>
                    </tr>
                    <tr>
                        <td><span class="icon-envelope"></span></td>
                        <td>{{env('EMAIL_FROM_ADDRESS')}}</td>
                    </tr>
                    <tr>
                        <td><span class="icon-phone"></span></td>
                        <td>{{env('PHONE')}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @if(count($gifts)>0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th>Desc</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gifts as $gift)
                <tr>
                    <td>{{date('d M y',strtotime($gift->created_at))}}</td>
                    <td>{{$gift->item}}</td>
                    <td>{{$gift->desc}}</td>
                    <td>{{$gift->amount}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>

    @else
        <hr/>
        <div class="alert alert-danger">No records found</div>
    @endif</div>

</body>
</html>