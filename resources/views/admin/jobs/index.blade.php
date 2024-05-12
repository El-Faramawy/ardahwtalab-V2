@extends('admin.index')
@section('title') الوظائف@stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الوظائف</span></h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a><i class="icon-home2 position-left"></i>الوظائف</a></li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    @if(Session::has('true'))
    <div class="alert alert-success">تم الاضافة بنجاح</div>
    @endif
    <!-- Content area -->
    <div class="content">
        <!-- Basic initialization -->
        <div class="panel panel-flat table-responsive">
            <table class="table datatable-key-basic">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الاكتروني</th>
                        <th>الجوال</th>
                        <th>عرض</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($list as $one)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            {{ $one->name }}
                        </td>
                        <td>{{ $one->name }}</td>
                        <td>{{ $one->email }}</td>
                        <td><a class="btn btn-primary fa fa-eye" href="{{route('jobs',['view'=>$one->id])}}"></a></td>
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
