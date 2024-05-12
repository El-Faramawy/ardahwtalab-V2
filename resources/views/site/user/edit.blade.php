@extends('site.user.profile')
@section('ptitle') إعدادات البيانات @stop
@section('part')
<div class="col-sm-8 col-lg-9">
    <div class="profile-body">
        <p class="profile-h">إعدادات البيانات</p>
        {{ Form::model($info,['route'=>['users.update',$info->id],'class'=>'profile-setting-form','method'=>'put','enctype'=>'multipart/form-data']) }}
        <div class="groub-div">
            <label for="name">الاسم</label>
            {{ Form::text('username',old('username'),['placeholder'=>'اسم المستخدم','required'=>'required']) }}
        </div>
        <div class="groub-div">
            <label for="mail">البريد الإلكتروني</label>
            {{ Form::email('email',old('email'),['placeholder'=>'البريد الإلكترونى','required'=>'required']) }}
        </div>
        <div class="groub-div">
            <label for="phone">رقم الجوال</label>
            {{ Form::text('phone',old('phone'),['id'=>'phone','placeholder'=>'966511111111','required'=>'required']) }}
        </div>
        <div class="groub-div">
            <label for="phone">صوره العضويه</label>
            <div class="input-div upload-div" style="width:100%">
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ $info->image }}" style="width:80px; height:80px" alt="">
                    </div>
                    <div class="col-sm-10">
                        <input id="image-input" type="file" name="image" accept="image/*">
                        <label for="image-input">
                            <font class="fontss def_text text_image"></font>
                            <span>اضافة صورة </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <?php /* <button class="setting-submit  hvr-rectangle-in" type="submit">حفظ التغييرات</button> */ ?>
        <div class="plus_add">
            <button type="submit">حفظ التغييرات</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
@stop
