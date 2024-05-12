@extends('admin.index')
@section('title') معلومات التواصل @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاعدادات العامة</span> - معلومات التواصل</h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
                <li><a>الاعدادات العامة</a></li>
                <li>معلومات التواصل</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Input group addons -->
        <div class="panel panel-flat table-responsive">
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    @if(Session::has('error'))
                    <div class="alert alert-warning">{{Session::get('error')}}</div>
                    @elseif(Session::has('true'))
                    <div class="alert alert-success">تم التعديل بنجاح</div>
                    @endif
                    <fieldset class="content-group">
                        <legend class="text-bold">معلومات التواصل</legend>
                        @if($contacts)
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="col-sm-3">نوع التواصل</div>
                                <div class="col-sm-3 ">رابط التواصل</div>
                                <div class="col-sm-3">عنوان العرض</div>
                            </div>
                        </div>
                        @foreach($contacts as $cn)
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="col-sm-3">
                                    <select class="form-control norselect" name="type[]">
                                        @foreach(contactTypes() as $key=>$ct)
                                        <option @if($cn->type==$key) selected @endif value="{{$key}}">
                                                 {{ $ct }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input value="{{$cn->value}}" class="form-control" name="value[]" type="text">
                            </div>
                            <div class="col-sm-3">
                                <input value="{{$cn->class}}" class="form-control" name="class[]" type="text">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-danger remove-contact" data-id="{{ $cn->id }}">
                                    <center><b>X</b></center>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="add-other-content @if($contacts) style-0 @endif">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="col-sm-3">
                                    <select class="form-control norselect" name="type[]">
                                        @foreach(contactTypes() as $key=>$ct)
                                        <option value="{{$key}}">
                                            {{ $ct }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" name="value[]" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" name="class[]" type="text">
                                </div>
                                <div class="col-sm-3">
                                    <a class="btn btn-danger remove-contact" data-id="0">
                                        <center><b>X</b></center>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="other-contacts"></div>
                    <div class="form-group">
                        <button class="btn btn-danger add-other"> + اضافة وسيلة اتصال اخرى</button>
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