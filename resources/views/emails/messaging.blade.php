<!DOCTYPE html>
<html lang="it">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{config('app.name')}}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {!! $msg !!}
        </div>
    </div>
</div>

<hr/>
Sent by {{Auth::user()->first_name.' '.Auth::user()->last_name}}
</body>
</html>