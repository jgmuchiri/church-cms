@extends('layouts.template')
@section('title')
    Sermons
@endsection

@section('crumbs')
    <a href="#">Sermons</a>
@endsection

@section('content')
    <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-list"></i></span>
            <h5>Sermons</h5>

            <div class="buttons">
                <a href="/sermons/admin" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> Sermons
                </a>
                <a href="/sermons/admin/drafts" class="btn btn-primary btn-mini">
                    <i class="icon-list-alt"></i> Drafts
                </a>
                <a href="/sermons/create" class="btn btn-inverse btn-mini">
                    <i class="icon-plus"></i> New Sermon
                </a>
            </div>
        </div>

        <div class="widget-content nopadding">
<br/>
            <ul class="stat-boxes2">
                <li>
                    <div class="right">
                        <strong>{{count($sermons->where('status','published'))}}</strong> Published
                    </div>
                </li>

                <li>
                    <div class="right">
                        <strong>{{count($sermons->where('status','draft'))}}</strong> Draft(s)
                    </div>
                </li>

            </ul>

            <table class="table table-striped">
                <tr>
                    <th></th>
                    <th>Published on</th>
                    <th>Topic</th>
                    <th>Speaker</th>
                    <th></th>
                </tr>
                @foreach($sermons as $s)
                    <tr>
                        <td>
                            @if($s->audio !==null)
                                <i class="icon-volume-up"></i>
                            @endif
                            @if($s->video !==null)
                                <i class="icon-camera"></i>
                            @endif
                        </td>

                        <td>{{date('d M y',strtotime($s->created_at))}}</td>

                        <td><a target="_blank"
                               href="/sermons/{{$s->slug}}">{{$s->title}}</a></td>
                        <td>{{$s->speaker}}</td>
                        <td>
                            <a href="/sermons/{{$s->id}}/edit" class="btn btn-info btn-mini"><i
                                        class="icon-pencil"></i> </a>
                            <a href="/sermons/{{$s->id}}/delete" class="btn delete btn-danger btn-mini"><i
                                        class="icon-trash"></i> </a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">{{$sermons->render()}}</div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.delete').click(function (e) {

        if (confirm('Are you sure?')) {
            return true;
        }

        e.preventDefault();
        return false;
    })
</script>
@endpush