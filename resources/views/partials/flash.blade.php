<script src="/plugins/bootstrap-notify/bootstrap-notify.js"></script>
<script>
    function notice(errorNote, type) {
        if (type === "error") {
            type = 'danger';
        }
        $.notify({
            icon: 'icon-check',
            message: errorNote

        }, {
            type: type,
            timer: 4000
        });
    }
</script>

@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash:modal',['modalClass'=>'flash-modal','title'=>session()->get('flash_notification.title'),
        'body'=>session()->get('flash_notification.body')])
    @else
        <script type="text/javascript">
            notice('{{session()->get('flash_notification.message')}}', '{{session()->get('flash_notification.level')}}')
        </script>

    @endif
@endif

@if(isset($errors) && $errors->any())
    @foreach($errors->all() as $error)
        <script>
            notice('<?php echo $error; ?>', 'danger');
        </script>
    @endforeach
@endif
