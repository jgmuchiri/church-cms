<div class="row-fluid">
    <div class="span12">
        <a href="/messaging/admin"
           class="btn btn-primary @if(Request()->segment(2)=='admin')active @endif">
            <i class="icon-plus-sign-alt"></i> @lang("New Message")
        </a>
        <a href="/messaging/history"
           data-toggle="tooltip" title="@lang("View all sent messages")"
           class="btn btn-success @if(Request()->segment(2)=="history")active @endif">
            <i class="icon-time"></i> @lang("Sent Messages")
        </a>

        <a href="/templates" data-toggle="tooltip" title="@lang("Templates to quickly re-use in the future")"
           class="btn btn-warning"><i class="icon-list"></i> @lang("Templates")
        </a>
        <a href="/messaging/mail-groups" data-toggle="tooltip" title="@lang("Manage messaging groups")"
           class="btn btn-info  @if(Request()->segment(2)=="mail-groups")active @endif"><i class="icon-group"></i> @lang("Groups")
        </a>
    </div>
</div>
