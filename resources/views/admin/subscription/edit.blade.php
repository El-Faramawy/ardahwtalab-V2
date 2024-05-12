@extends('admin.index')
@section('title')  تعديل اشتراك</title>
{{--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
{{--  <script>tinymce.init({selector:'textarea'});</script>--}}
<script src="https://cdn.ckeditor.com/4.19.0/full-all/ckeditor.js"></script>

@stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاشتراكات</span> - تعديل  اشتراك</h4>
            </div>
        </div>
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('advs.index')}}">الاشتراكات</a></li>
                <li>تعديل اشتراك</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Input group addons -->
        <div class="panel panel-flat table-responsive">
            <div class="panel-body">
                <form action="{{ route('admin.subscription.update' , ['subscription' => $subscription->id]) }}" class="form-horizontal" method="post" enctype="multipart/form-data" files>
                    @if(Session::has('error'))
                    <div class="alert alert-warning">{!! html_entity_decode(Session::get('error')) !!}</div>
                    @elseif(Session::has('true'))
                    <div class="alert alert-success">تم التعديل بنجاح</div>
                    @endif
                    <fieldset class="content-group">
                        <legend class="text-bold">تعديل اشتراك</legend>

                        <div class="advs_details"></div>
                        <div class="advs_proptypes"></div>

                       <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">العنوان</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input class="form-control" name="title" value="{{ old('title') ?? $subscription->title ?? '' }}" placeholder="العنوان">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">السعر</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input class="form-control" value="{{ old('price') ?? $subscription->price ?? '' }}" name="price" placeholder="السعر">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">الوصف</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <textarea class="form-control" name="description" id="description" placeholder="الوصف">{{ old('description') ?? $subscription->description ?? '' }}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">مدة العرض بالساعة</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input class="form-control" value="{{ old('duration') ?? $subscription->duration ?? '' }}" name="duration" id="duration_h" placeholder="ادخل مدة هذا العرض بالساعات">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2">المدة بالايام</label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input class="form-control" disabled  id="duration_d" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="type_details">
                            <div class="form-group">
                                <label class="control-label col-lg-2"> الحالة </label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="checkbox" name="active" class="form-control"   id="duration_d" placeholder="" {{ old('active') ?? $subscription->active == "1" ? 'checked' : '' }} >
                                    </div>
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
{{--<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>--}}

<script>
    CKEDITOR.config.contentsLangDirection = 'rtl';
    CKEDITOR.replace( 'description' );
</script>

<script>
var duration_d = 0;
    $("#duration_h").on('input' ,function(){
        duration_d = $('#duration_h').val() / 24 ;
        $('#duration_d').val(duration_d);
    });
</script>
<!-- /content wrapper -->
@stop
