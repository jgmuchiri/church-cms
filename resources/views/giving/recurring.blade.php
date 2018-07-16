@extends('layouts.admin-template')
@section('title')
    @lang("Recurring Gifts")
@endsection
@section('crumbs')
    <a href="#">@lang("Recurring gifts")</a>
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header"><span class="icon">
                <a href="/giving/gifts"><i class="fa fa-chevron-left"></i></a>
            </span>
            <h5>@lang("Cancellations will take effect on the next billing cycle")</h5>
        </div>
        <div class="card-body nopadding">
            <table class="table table-bordered data-table selec2">

                <thead>
                <tr>
                    <th>@lang("Date")</th>
                    <th>@lang("Subscription ID")</th>
                    <th>@lang("Amount")</th>
                    <th>@lang("Interval")</th>
                    <th>@lang("Ends On")</th>
                    <th>@lang("Status")</th>
                    <th data-orderable="false"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($gifts as $gift)
                    <tr>
                        <td>{{date('d M, Y',strtotime($gift->created_at))}}</td>
                        <td>{{$gift->subscription_id}}</td>
                        <td>{{config('app.currency.symbol').$gift->amount}}</td>
                        <td>{{ucwords($gift->interval)}}</td>
                        <td>{{$gift->ends_at}}</td>
                        <td>{{ucwords($gift->status)}}</td>
                        <td>
                            {{--<a href="/giving/plan/{{$gift->id}}/suspend" class="label label-warning"><i class="fa fa-warning"></i> Suspend</a>--}}
                            @if($gift->status =="active")
                                <a href="/giving/plan/{{$gift->id}}/cancel" class="label label-danger"><i
                                            class="fa fa-times"></i> @lang("Cancel")</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@include('partials.datatables')