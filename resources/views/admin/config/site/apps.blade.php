@extends('admin.index')
@section('title') لينكات التطبيق @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <i class="icon-arrow-right6 position-right"></i>
                    <span class="text-semibold">الاعدادات العامة</span>
                    <span> - </span>
                    <span>لينكات التطبيق</span>
                </h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
                <li><a>الاعدادات العامة</a></li>
                <li>لينكات التطبيق</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Input group addons -->
        <div class="panel panel-flat table-responsive">
            <div class="panel-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    @if(Session::has('error'))
                    <div class="alert alert-warning">{{Session::get('error')}}</div>
                    @elseif(Session::has('true'))
                    <div class="alert alert-success">تم التعديل بنجاح</div>
                    @endif
                    <fieldset class="content-group">
                        <legend class="text-bold">لينكات التطبيق</legend>
                        <div class="form-group">
                            <label class="control-label col-lg-2">أندرويد</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon fa fa-android"></span>
                                    <input type="text" value="{{$info->android}}" name="android" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">آيفون</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon fa fa-apple"></span>
                                    <input type="text" value="{{$info->ios}}" name="ios" class="form-control">
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">تعديل<i class="icon-arrow-left13 position-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /input group addons -->
    </div>
    <!-- /content area -->
</div>
<!-- /content wrapper -->
@stop