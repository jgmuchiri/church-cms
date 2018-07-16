@push('styles')
@if(config('app.env')=='local')
    <link rel="stylesheet" href="/plugins/trumbowyg/trumbowyg.min.css">
    <link rel="stylesheet"
          href="/plugins/trumbowyg/trumbowyg.colors.min.css">

    <script src="/plugins/trumbowyg/trumbowyg.min.js"></script>
@else
    <link rel="stylesheet" href="//cdn.rawgit.com/Alex-D/Trumbowyg/v2.1.0/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet"
          href="//cdn.rawgit.com/Alex-D/Trumbowyg/v2.1.0/dist/plugins/colors/ui/trumbowyg.colors.min.css">

    <script src="//cdn.rawgit.com/Alex-D/Trumbowyg/v2.1.0/dist/trumbowyg.min.js"></script>
@endif
@endpush
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.editor').trumbowyg({
            autogrow: true
        });
    });

    //        $('.editor').trumbowyg({
    //            btns: ['strong', 'em', '|', 'insertImage'],
    //            autogrow: true
    //        });
</script>
@endpush