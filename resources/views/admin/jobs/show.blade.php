@extends('admin.index')
@section('title') تفاصيل الطلب@stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الوظائف</span> - تفاصيل الطلب </h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a><i class="icon-home2 position-left"></i> الوظائف</a></li>
                <li><a>تفاصيل الطلب </a></li>
            </ul>
        </div>
    </div>
    <!-- Content area -->
    <div class="content">
        <!-- Basic initialization -->
        <div class="panel panel-flat table-responsive">
            <table class="table datatable-key-basic">
                <tr>
                    <th>رقم الطلب</th>
                    <td>{{ $info->id }}</td>
                </tr>
                <tr>
                    <th>الاسم</th>
                    <td>{{ $info->name }}</td>
                </tr>
                <tr>
                    <th>البريد الاكتروني</th>
                    <td>{{ $info->email }}</td>
                </tr>
                <tr>
                    <th>الجوال</th>
                    <td>{{ $info->mobile }}</td>
                </tr>
                <tr>
                    <th>الملف المرفق</th>
                    <td><a target="_blank" href="{{ asset('uplaods/jobs/'.$info->file) }}">تحميل</a></td>
                </tr>
                <tr>
                    <th>ملاحظات</th>
                    <td>{{ $info->notes }}</td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /page header -->
</div>
@stop