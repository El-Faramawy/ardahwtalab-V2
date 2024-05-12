@extends('admin.index')
@section('title') اضافة نظام دفع @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">أنظمة الدفع</span> - اضافة نظام دفع</h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('paymethods.index')}}">أنظمة الدفع</a></li>
                <li>اضافة نظام دفع</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content">

        <!-- Input group addons -->
        <div class="panel panel-flat table-responsive">
            <div class="panel-body">
                <form action="{{ route('paymethods.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    @if(Session::has('error'))
                    <div class="alert alert-warning">{{Session::get('error')}}</div>
                    @elseif(Session::has('true'))
                    <div class="alert alert-success">تم التعديل بنجاح</div>
                    @endif
                    <fieldset class="content-group">
                        <legend class="text-bold">نظام دفع</legend>

                        <div class="form-group">
                            <label class="control-label col-lg-2">اسم نظام دفع</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" required class="form-control" name="name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">نوع النظام</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select name="type" class="form-control">
                                        @foreach(payTypes() as $key=>$pt)
                                        <option value="{{$key}}">
                                            {{$pt}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2">صورة دالة</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="file" id="uploadfile" name="image">
                                </div>
                            </div>
                        </div>
                        <?php
                        /*

                          <div class="form-group">
                          <label class="control-label col-lg-12">معلومات النظام</label>
                          <div class="col-lg-12">
                          <div class="input-group">
                          <textarea id="editor" name="info"></textarea>
                          </div>
                          </div>
                          </div>
                         */
                        ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2">معلومات النظام</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" required class="form-control" value="" name="info">
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </fieldset>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">حفظ<i class="icon-arrow-left13 position-right"></i></button>
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
