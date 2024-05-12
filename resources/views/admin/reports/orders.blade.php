@extends('admin.index')
    @section('title')  تقارير الطلبات الوساطه @stop
@section('page')
    <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> التقارير </span> -  الطلبات الوساطه </h4>
                    </div>

                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a><i class="icon-home2 position-left"></i>التقارير</a></li>
                        <li><a> الطلبات الوساطه </a></li>
                    </ul>
                    <div style=" position: absolute; left: 30px; ">
                        <form action="">
                            <input type="date" value="{{ request('from',date('Y-m-d')) }}" style="border: 0px;" name="from" id=""> -
                            <input type="date" value="{{ request('to',date('Y-m-d')) }}" style="border: 0px;" name="to" id="">
                            <input type="submit" class="btn btn-primary" value="بحث">
                        </form>
                    </div>
                </div>
            </div>

            <div class="content">
                @foreach ($data['counters'] as $item)
                    @include('admin.reports.layout.count',$item)
                @endforeach
            </div>

            <!-- Content area -->
            <div class="content">
                <!-- Basic initialization -->
                <div class="panel panel-flat table-responsive">
                    <table class="table datatable-key-basic">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المستخدم</th>
								<th>المنطقة </th>
								<th>قسم الطلب</th>
								<th>حالة الطلب</th>
								<th>المحامى المعين</th>
								@if(!request('lawyer_id'))
								<th>المحامين</th>
								@endif
								<th>عرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1;?>
                            @foreach ($data['lists'] as $info)
                                <tr>
                                    <td>{{ $index }} <?php $index++; ?></td>
                                    <td>{{ $info->name ?? $info->user->username ?? '#' }}</td>
                                    <td>{{ $info->area->name ?? '#' }}</td>
                                    <td>{{ $info->category->name ?? 'أخري' }}</td>
                                    <td>{{ $info->my_status }}</td>
                                    <th>{{ $info->lawyer()->first()->fullname ?? '#' }}</th>
                                    @if(!request('lawyer_id'))
                                    <td><a class="btn btn-primary fa fa-list" href="{{ route('admin.lawsuits.lawyers' , $info->id) }}"></a></td>
                                    @endif
                                    <td><a class="btn btn-success fa fa-eye show_lawsuit_details" data-href="{{ route('lawsuit.show' , $info->id) }}"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /basic initialization -->
            </div>
            <!-- /content area -->

        </div>
    <!-- /main content -->
@stop
