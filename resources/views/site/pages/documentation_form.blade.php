@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/contactus.css")}}">
@endpush
@section('title') توثيق العضوية  @stop
@section('page')
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="contact-send">
                    <h3>أرسل البيانات</h3>
                    <form novalidate class="phi-form" method="POST" enctype="multipart/form-data">
                        @if(Session::has('true'))
                        <div class="alert alert-success">  تم رفع الوثائق بنجاح  </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger">{{ Session::has('error') }}</div>
                        @endif
                        <p>الاسم</p>
                        <input id="field2" placeholder="ادخل الإسم كما هو في بيانات الوثيقة" required dir="auto" type="text" value="" name="name">
                        <p>نوع الوثيقه</p>
                        <div class="categories extra">
                            <select class="selectpicker" required id="field3" name="category_id" rel="f4">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->title }} </option>
                                @endforeach
                            </select>
                        </div>
                        <p>رقم الوثيقه</p>
                        <input id="field1" dir="rtl" type="text" value="" name="documentation_number">
                        <p>معلومات اخري</p>
                        <textarea dir="auto" id="field8" name="info" rows="5"></textarea>
                        <p>صوره الوثيقه</p>
                        <input id="field1" dir="rtl" type="file" name="image">
                        {{ csrf_field() }}
                        <button type="submit">إرسال </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop