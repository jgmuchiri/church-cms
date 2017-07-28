@extends('layouts.template')
@section('content')
    <div class="quick-actions_homepage">
        <ul class="quick-actions">
            <li class="bg_lg">
                <a href="/giving/gifts"> <i class="icon-money"></i>
                    <span class="label label-success">
                        ${{App\Models\Billing\Transactions::sum('amount')}}
                    </span>
                    Gifts</a>
            </li>

            <li class="bg_lb">
                <a href="/messaging/admin">
                    <i class="icon-envelope-alt"></i>
                    <span class="label label-important"></span>
                    Messages
                </a>
            </li>

            <li class="bg_ls">
                <a href="/sermons/admin">
                    <i class="icon-th"></i>
                    <span class="label label-info">
                        {{App\Models\Sermons::count()}}
                    </span>
                    Sermons
                </a>
            </li>

            <li class="bg_lo">
                <a href="/blog/admin">
                    <i class="icon-leaf"></i>
                    <span class="label label-warning">
                        {{App\Models\Blog\Blog::count()}}
                    </span>
                    Blog
                </a>
            </li>

            <li class="bg_lg">
                <a href="/events/admin">
                    <i class="icon-calendar"></i> Calendar
                </a>
            </li>

            <li class="bg_lo">
                <a href="/support">
                    <i class="icon-question-sign"></i>
                    <span class="label label-warning">{{App\Models\Kb::whereActive(0)->count()}}</span>
                    Support
                </a>
            </li>

        </ul>
    </div>


    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
                <h5>Site Analytics</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span9">
                        @include('giving.monthly-gift-stats')
                    </div>
                    <div class="span3">
                        <ul class="site-stats">
                            <li class="bg_lh"><i class="icon-user"></i> <strong>{{\App\User::count()}}</strong>
                                <small>Total User(s)</small>
                            </li>
                            <li class="bg_lh"><i class="icon-question-sign"></i> <strong>
                                    {!! \App\Models\Kb::count() !!}
                                </strong>
                                <small>Questions</small>
                            </li>
                            <li class="bg_lh"><i class="icon-calendar"></i> <strong>
                                    {{\App\Models\Events::count()}}
                                </strong>
                                <small>Events</small>
                            </li>
                            <li class="bg_lh"><i class="icon-tag"></i> <strong>
                                    {!! \App\Models\Sermons::count() !!}
                                </strong>
                                <small>Sermons</small>
                            </li>
                            <li class="bg_lh"><i class="icon-th"></i> <strong>
                                    {{\App\Models\Ministry\Ministry::count()}}
                                </strong>
                                <small>Ministries</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection