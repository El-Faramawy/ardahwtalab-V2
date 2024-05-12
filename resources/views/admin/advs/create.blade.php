@extends('admin.index')
@section('title') اضافة إعلان @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الإعلانات</span> - اضافة إعلان</h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('advs.index')}}">الإعلانات</a></li>
                <li>اضافة إعلان</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Input group addons -->
        <div class="panel panel-flat table-responsive">
            <div class="panel-body">
                <form action="{{ route('advs.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data" files>
                    @if(Session::has('error'))
                    <div class="alert alert-warning">{!! html_entity_decode(Session::get('error')) !!}</div>
                    @elseif(Session::has('true'))
                    <div class="alert alert-success">تم التعديل بنجاح</div>
                    @endif
                    <fieldset class="content-group">
                        <legend class="text-bold">إضافة إعلان</legend>
                        <div class="form-group">
                            <label class="control-label col-lg-2">القسم</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select required class="form-control selectpicker advs_dept_id" data-live-search="true" name="dept" id="advs_dept_id" data-action="{{route('getDetails')}}" data-title="اختر القسم">
                                        @foreach($depts as $dp)
                                        <option value="{{$dp->id}}">{{$dp->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="advs_details"></div>
                        <div class="advs_proptypes"></div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">حالة المنتج</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select required class="form-control" name="status">
                                        <option value="1">جديد</option>
                                        <option value="0">مستعمل</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">السعر</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input class="form-control" name="price" placeholder="السعر">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">عنوان الإعلان</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">التفاصيل</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <textarea rows="5" id="editor" required class="form-control" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">الكلمات الدالة</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input name="keywords" id="tags" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">صور الإعلان</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input required type="file" id="multi-uploadfile" multiple class="form-control" name="images[]">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">المنطقة</label>
                            <div class="col-lg-10">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <select required data-live-search="true" class="form-control" name="country" id="country">
                                            <option selected disabled>أختر الدولة</option>
                                            @foreach($country as $dt)
                                            <option value="{{$dt->id}}">{{$dt->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group area_content">
                                        <select required class="form-control" name="area" id="area">
                                            <option selected disabled>اختر المنطقة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript"> getMap()</script>
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
