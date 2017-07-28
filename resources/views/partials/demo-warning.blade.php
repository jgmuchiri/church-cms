@if(env('DEMO_MODE'))
    <div class="callout callout-danger"><h4>Demo mode warning!</h4>
        This application is in demo mode but any transactions are in real time. If you make any real transaction,
        no refunds will be issued. If you need to test the system, consider using very small amounts.
    </div>
@endif