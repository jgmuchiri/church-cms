@if(count($gifts)>0)
    <table class="table table-bordered data-table">
        <thead>
        <tr>
            <th>Date</th>
            <th>ID</th>
            <th>Item</th>
            <th>Amount</th>
            <th>Desc</th>
        </tr>
        </thead>
        <tbody>
        @foreach($gifts as $gift)
            <tr>
                <td><a href="/giving/gift/{{$gift->txn_id}}">{{date('d M y',strtotime($gift->created_at))}}</a></td>
                <td><a href="/giving/gift/{{$gift->txn_id}}">{{$gift->txn_id}}</a></td>
                <td>{{$gift->item}}</td>
                <td>{{$gift->amount}}</td>
                <td>{{$gift->desc}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>

@else
    <hr/>
    <div class="alert alert-danger">No records found</div>
@endif
@include('partials.datatables')