@extends('site.index')
@section('title') طلبات الوساطة القانونية : {{ $title }} @stop
@section('page')
<!-- start profile section -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-lg-3">
                <div class="side-menu-div">
                    <ul class="side-menu">
                        <li><a href="{{ route('lawyer.lawsuits' , ['type' => 'pending']) }}">طلبات جديدة</a></li>
                        <li><a href="{{ route('lawyer.lawsuits' , ['type' => 'approved']) }}">طلباتي</a></li>
                        <li><a href="{{ route('lawyer.lawsuits' , ['type' => 'accepted']) }}">طلبات بانتظار تأكيد المشرف</a></li>
                        <li><a href="{{ route('lawyer.lawsuits' , ['type' => 'rejected']) }}">طلبات مرفوضة</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-lg-9">
                <div class="profile-body">
                    <p class="profile-h">{{ $title }}</p>
                    <table class="table table-responsive">
                        <thead>
                            <th>رقم الدعوى</th>
                            <th>الاسم</th>
                            <th>المدينة</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name ?? $row->user->username ?? '#' }}</td>
                                <td>{{ $row->area->name ?? 'الرياض' }}</td>
                                <td>
                                    <a style="float:left" href="#!" data-href="{{ route('lawsuit.show' , [$row->id , 'type' => request('type')]) }}"
                                        class="btn btn-success show_lawsuit_details">
                                        <i class="fa fa-eye"></i> عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end profile section -->

@stop