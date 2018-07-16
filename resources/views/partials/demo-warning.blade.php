@if(config('app.demo'))
    <div class="callout callout-danger"><h4>@lang("Demo mode warning!")</h4>
        @lang("This application is in demo mode but any transactions are in real time. If you make any real transaction,
        no refunds will be issued.")
        @lang("If you need to test the system, consider using very small amounts.")
    </div>
@endif