@push('scripts')
	<script src="/plugins/datatables/jquery.dataTables.js"></script>
	<script src="/plugins/datatables/dataTables.bootstrap4.js"></script>
	<script src="/plugins/datatables/dataTables.buttons.js"></script>
	<script src="/plugins/datatables/buttons.bootstrap.js"></script>
	<script src="/plugins/datatables/buttons.colVis.js"></script>
	<script src="/plugins/datatables/buttons.flash.js"></script>
	<script src="/plugins/datatables/buttons.html5.js"></script>
	<script src="/plugins/datatables/buttons.print.js"></script>
	<script src="/plugins/datatables/dataTables.keyTable.js"></script>
	<script src="/plugins/datatables/dataTables.responsive.js"></script>
	<script src="/plugins/datatables/responsive.bootstrap.js"></script>
	<script src="/plugins/datatables/jszip.js"></script>
	<script src="/plugins/datatables/pdfmake.js"></script>
	<script src="/plugins/datatables/vfs_fonts.js"></script>
	<script>
        (function () {
            'use strict';
            $(tableDatatables);
            function tableDatatables() {
                if (!$.fn.DataTable) return;
                $('#table-default').DataTable({
                    'paging': true, // Table pagination
                    'ordering': true, // Column ordering
                    'info': true, // Bottom left status text
                    responsive: true,
                    // Text translation options
                    // Note the required keywords between underscores (e.g _MENU_)
                    oLanguage: {
                        sSearch: '<em class="ion-search"></em>',
                        sLengthMenu: '_MENU_ records per page',
                        info: 'Showing page _PAGE_ of _PAGES_',
                        zeroRecords: 'Nothing found - sorry',
                        infoEmpty: 'No records available',
                        infoFiltered: '(filtered from _MAX_ total records)',
                        oPaginate: {
                            sNext: '<em class="fa fa-caret-right"></em>',
                            sPrevious: '<em class="fa fa-caret-left"></em>'
                        }
                    }
                });
            }
        })();

        $('document').ready(function () {
            $('#users').DataTable({
                'paging': true, // Table pagination
                'ordering': true, // Column ordering
                'info': true, // Bottom left status text
                responsive: true,
                // Text translation options
                // Note the required keywords between underscores (e.g _MENU_)
                oLanguage: {
                    sSearch: 'Search all columns:',
                    sLengthMenu: '_MENU_ records per page',
                    info: 'Showing page _PAGE_ of _PAGES_',
                    zeroRecords: 'Nothing found - sorry',
                    infoEmpty: 'No records available',
                    infoFiltered: '(filtered from _MAX_ total records)',
                    oPaginate: {
                        sNext: '<em class="fa fa-caret-right"></em>',
                        sPrevious: '<em class="fa fa-caret-left"></em>'
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'copy', className: 'btn-info'},
                    {extend: 'csv', className: 'btn-info'},
                    {extend: 'excel', className: 'btn-info', title: 'XLS-File'},
                    {extend: 'pdf', className: 'btn-info', title: $('title').text()},
                    {extend: 'print', className: 'btn-info'}
                ]
            });
        })
	</script>
@endpush