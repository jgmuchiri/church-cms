@push('styles')
<link rel="stylesheet" href="/plugins/select2/select2.min.css"/>
@endpush
@push('scripts')
<script src="/plugins/select2/select2.min.js" type="text/javascript"></script>
<script>
    $('{{$select2}}').select2();
</script>
@endpush