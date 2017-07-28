@extends('layouts.template')
@section('title')
    Gift Details
@endsection


@section('content')
    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
            {{date('d M y',strtotime($txn->created_at))}}
            <div class="buttons">
                <a href="/gifts" class="btn btn-inverse btn-mini"><i class="icon-chevron-sign-right"></i> </a>
            </div>
        </div>
        <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <tr>
                    <td>Amount:</td>
                    <td><p class="category">{{env('CURRENCY_SYMBOL').$txn->amount}}</p></td>
                </tr>
                <tr>
                    <td style="width:150px;">Item:</td>
                    <td>{{$txn->item}}</td>
                </tr>
                <tr>
                    <td>User:</td>
                    <td>{{App\User::whereId($txn->user_id)->first()->first_name}}
                        {{App\User::whereId($txn->user_id)->first()->last_name}}
                    </td>
                </tr>
                <tr>
                    <td>Desc:</td>
                    <td>

                        <p>{{$txn->desc}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection