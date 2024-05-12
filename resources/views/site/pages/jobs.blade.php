@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/transfer.css")}}">
@endpush
@section('title') التوظيف@stop
@section('page')
<div class="contact jobs">
    <div class="container">
        <form novalidate enctype="multipart/form-data" action="" id="myForm" method="POST">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="contact-send">
                        <h3>نموذج التوظيف</h3>
                        <p>الاسم</p>
                        <input id="field1" required name="name" dir="auto" type="text" value="{{old('name')}}">
                        <p>البريد الإلكتروني</p>
                        <input id="field1" required name="email" dir="auto" type="email" value="{{old('email')}}">
                        <p>الجوال</p>
                        <input id="field1" required name="mobile" dir="auto" type="text" value="{{old('mobile')}}">
                        <p>المرفقات</p>
                        <input id="field1" class="file" name="file" type="file" __accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/*,application/pdf,application/msword,text/html">
                        <div class="other">
                            <p>ملاحظات</p>
                            <textarea id="field8" name="notes" dir="auto">{{old('notes')}}</textarea>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit">إرسال البيانات</button>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </form>
    </div>
</div>
@stop