@extends('layouts.admin-template')
@section('title')
    @lang("Gifts")
@endsection
@section('crumbs')
    <a href="#">@lang("Gifts")</a>
@endsection

@section('content')
    <div class="card card-default widget-plain">
        <div class="center">
            <ul class="stat-boxes2">
                <li>
                    <div class="left peity_bar_neutral">
                        <i class="icon-bar-chart icon-4x"></i>
                    </div>
                    <div class="right">
                        <strong> {{env('CURRENCY_SYBMBOL').App\Models\Billing\Transactions::sum('amount')}} </strong>
                        @lang("Contributions")
                    </div>
                </li>
                <li>
                    <div class="left peity_bar_neutral">
                        <i class="icon-money icon-4x"></i>
                    </div>
                    <div class="right">
                        <strong>  {{App\Models\Billing\Transactions::count()}}</strong>
                        @lang("Transactions")
                    </div>
                </li>
                <li><a href="/giving/recurring">
                        <div class="left peity_bar_neutral">
                            <i class="icon-refresh icon-4x"></i>
                        </div>
                        <div class="right">
                            <span>@lang("Recurring gifts")</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-header"><span class="icon"><i class="icon-th"></i></span>
            <h5>@lang("Giving history")</h5>
            <div class="buttons">
                <a href="/reports/downloadGiftsToDate" class="btn btn-inverse btn-mini no-print">
                    <i class="icon-download-alt"></i> @lang("Download CSV")</a>
            </div>
        </div>
        <div class="card-body nopadding">
            @if(count($txns)>0)
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>@lang("Date")</th>
                        <th class="no-print">@lang("ID")</th>
                        <th>@lang("Name")</th>
                        <th>@lang("Amount")</th>
                        <th>@lang("Description")</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($txns as $txn)
                        <tr>
                            <td>
                                {{date('d M y',strtotime($txn->created_at))}}
                            </td>
                            <td class="no-print">
                                <a href="#" class="gift-details" id="{{$txn->txn_id}}">{{$txn->txn_id}}</a>
                            </td>
                            <td>{{$txn->item}}</td>
                            <td>{{env('CURRENCY_SYMBOL').$txn->amount}}</td>
                            <td>{{$txn->desc}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger">@lang("No records found")</div>
            @endif
        </div>
    </div>
@endsection
@include('partials.datatables')
@push('scripts')
<script>
    $('.gift-details').click(function () {

        var id = $(this).attr('id');

        $.ajax({
            url: '/giving/gift',
            data: {id: id, _token: '{{csrf_token()}}'}, //$('form').serialize(),
            type: 'POST',
            success: function (response) {
                var data = JSON.parse(response);
                var modal = $('#giftModal');
                modal.find('#date').text(data.created_at);
                modal.find('#user').text(data.user_id);
                modal.find('.modal-title').text(data.user_id);
                modal.find('#amount').text(data.amount);
                modal.find('#desc').text(data.desc);
                modal.find('#item').text(data.item);
                modal.modal('show');
            },
            error: function (error) {
                notice('Error!');
            }
        });
    })
</script>
@endpush

@push('modals')
<div class="modal fade" id="giftModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered data-table">
                    <tr>
                        <td>Date</td>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <td>Amount:</td>
                        <td id="amount"></td>
                    </tr>
                    <tr>
                        <td style="width:150px;">Item:</td>
                        <td id="item"></td>
                    </tr>
                    <tr>
                        <td>User:</td>
                        <td id="user"></td>
                    </tr>
                    <tr>
                        <td>Desc:</td>
                        <td id="desc"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endpush