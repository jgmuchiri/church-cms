@extends('layouts.template')
@section('title')
    Gifts
@endsection
@section('crumbs')
    <a href="#">Gifts</a>
@endsection

@section('content')
    <div class="widget-box widget-plain">
        <div class="center">
            <ul class="stat-boxes2">
                <li>
                    <div class="left peity_bar_neutral">
                        <i class="icon-bar-chart icon-4x"></i>
                    </div>
                    <div class="right">
                        <strong> {{env('CURRENCY_SYBMBOL').App\Models\Billing\Transactions::sum('amount')}} </strong>
                        Contributions
                    </div>
                </li>
                <li>
                    <div class="left peity_bar_neutral">
                        <i class="icon-money icon-4x"></i>
                    </div>
                    <div class="right">
                        <strong>  {{App\Models\Billing\Transactions::count()}}</strong>
                        Transactions
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>Giving history</h5>
            <div class="buttons">
                <a href="/reports/downloadGiftsToDate" class="btn btn-inverse btn-mini no-print" data-toggle="tooltip"
                   title="Download CSV">
                    <i class="icon-download"></i></a>
            </div>
        </div>
        <div class="widget-content nopadding">
            @if(count($txns)>0)
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th class="no-print">ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Desc</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($txns as $txn)
                        <tr>
                            <td>
                                <a class="no-print"
                                   href="/gift/{{$txn->txn_id}}">{{date('d M y',strtotime($txn->created_at))}}</a>
                                <span class="print-only">{{date('d M y',strtotime($txn->created_at))}}</span>
                            </td>
                            <td class="no-print">
                                <a href="/gift/{{$txn->txn_id}}">{{$txn->txn_id}}</a>
                            </td>
                            <td>{{$txn->item}}</td>
                            <td>{{env('CURRENCY_SYMBOL').$txn->amount}}</td>
                            <td>{{$txn->desc}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger">No records found</div>
            @endif
        </div>
    </div>
@endsection
@include('partials.datatables')