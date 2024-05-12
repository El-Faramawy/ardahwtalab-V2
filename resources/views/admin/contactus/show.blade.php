@extends('admin.index')
@section('title') {{ $info->subject }} @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - {{ $info->subject }} </h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
                <li><a>{{ $info->subject }} </a></li>
            </ul>
        </div>
    </div>
    <!-- Content area -->
    <div class="content">
        <!-- Basic initialization -->
        <div class="panel panel-flat table-responsive">
            <table class="table datatable-key-basic">
                <tr>
                    <th>عنوان الرسالة</th>
                    <td>{{ $info->subject }}</td>
                </tr>
                <tr>
                    <th>البريد الإلكترونى</th>
                    <td>{{ $info->email }}</td>
                </tr>
                <tr>
                    <th>تاريخ الإرسال</th>
                    <td>{{ $info->created_at }} - - - {{ time_ago($info->created_at) }}</td>
                </tr>
                <tr>
                    <th>الغرض</th>
                    <td>{{ $info->purpose }}</td>
                </tr>
                <tr>
                    <th>الأهمية</th>
                    <td>{{ $info->important }}</td>
                </tr>
                <tr>
                    <th>الرسالة</th>
                    <td><textarea disabled style="width: 100%; border: 0px; background:transparent;" rows="5">{{ $info->msg }}</textarea></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /page header -->
</div>
@stop