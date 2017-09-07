<div id="chartActivity" class="ct-chart"></div>

@push('scripts')
<script src="{{asset('plugins/highcharts/highcharts.js')}}"></script>
<script src="{{asset('plugins/highcharts/exporting.js')}}"></script>
<script type="text/javascript">
    $(function () {
        $('#chartActivity').highcharts({
            title: {
                text: '@lang("Monthly Reports")',
                x: -20 //center
            },
            subtitle: {
                text: '@lang("Here is how we are doing so far")',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Views'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ''
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [

                {
                    name: '@lang("Members")',
                    data: [{{App\Models\Reports::usersByMonth()}}]
                },
                {
                    name: '@lang("Contributions")',
                    data: [{{App\Models\Reports::montlyGiving()}}]
                }

            ]
        });
    });
</script>

@endpush