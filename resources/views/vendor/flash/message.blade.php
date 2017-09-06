@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => session()->get('flash_notification.title'), 'body' => session()->get('flash_notification.message')])
    @else
        <div class="alert alert-{{ session()->get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

            {!! session()->get('flash_notification.message') !!}
        </div>
    @endif
@endif
