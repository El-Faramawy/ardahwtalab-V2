@extends('admin.index')
@section('title') الإعدادات العامة @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاعدادات العامة</span></h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
                <li><a>الاعدادات العامة</a></li>
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
                        <legend class="text-bold">الاإعدادات العامة</legend>
                        <div class="form-group">
                            <label class="control-label col-lg-2">عنوان الموقع</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="title" value="{{$info->title}}" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">تفعيل العضويات من خﻻل</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select class="form-control" name="active_by">
                                        @foreach(activeBy() as $key=>$ac)
                                        <option @if($info->active_by==$key) selected @endif value="{{$key}}">{{$ac}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">لوجو الموقع</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="file" @if($info->logo)data-file="{{url('/').$info->logo}}" @endif id="uploadfile" class="form-control" name="logo">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">الشعار المصغر الموقع</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="file" @if($info->favicon)data-file="{{url('/').$info->favicon}}" @endif id="uploadfile2" class="form-control" name="favicon">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">وصف الموقع</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <textarea rows="5" class="form-control" name="description">{{ $info->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">الكلمات الدﻻلية</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <textarea rows="5" class="form-control" name="keywords">{{ $info->keywords }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="control-label col-lg-2">بي بال</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                   <select class="form-control" name="paypal">
                                       <option value="1" <?php if($info->paypal == 1) echo "selected"; ?>>تشغيل</option>
                                       <option value="0" <?php if($info->paypal == 0) echo "selected"; ?>>تعطيل</option>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">رساله نصية لتعين المحامي</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <textarea rows="5" class="form-control" name="appoint_msg">{{ $info->appoint_msg }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2"></label>
                            <div class="col-lg-10">
                                <div class="input-group" style="direction: ltr;">
                                    <code>
                                        name : [NAME]
                                    </code>
                                    <code>
                                        email : [EMAIL]
                                    </code>
                                </div>
                            </div>
                        </div>
                        -->
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