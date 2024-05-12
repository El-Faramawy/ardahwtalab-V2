@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/blacklist.css")}}">
@endpush
@section('title') القائمة السوداء @stop
@section('page')
<div id="content" class="col-md-12 nopadding"> 
    <div class="container">
        <div class="blackbox">
            <h2>البحث في القائمة السوداء</h2>
            <p>القائمة السوداء هي قائمة بأسماء حسابات وأرقام جوالات من يقومون بإساءة استخدام الموقع لأغراض ممنوعة مثل الغش أو الإحتيال أو مخالفة قوانين الموقع</p>
        </div>
        <div class="blacklist-result">
            @if(isset($_GET['word']))
            @if(!$user)
            <div class="alert alert-warning">
                لا يوجد هذا المستخدم فى القائمة السوداء
            </div>
            @else
            <div class="alert alert-danger">
                هذا المستخدم بالفعل فى القائمة السوادء
            </div>
            @endif
            @endif
        </div>
        <div class="go">
            <h3>أدخل اسم الحساب أو رقم الجوال</h3>
            <form novalidate class="phi-form" method="GET" action="">
                <input name="word" class="go-input" value="<?php echo request('word', '') ?>">
                <input type="submit" class="go-btn" value="استكشف">
            </form>
        </div>
    </div>
</div>
@stop