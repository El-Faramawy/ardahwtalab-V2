@extends('site.index')
@section('title') تفعيل الحساب وتعيين كلمة المرور@stop
@section('page')
<div>
    <p class="form-h"> تفعيل الحساب وتعيين كلمة المرور</p>
    @include('validate')
    <form novalidate class="modal-form" method="post">
        <input name="password" required type="password" placeholder="كلمة السر" />
        <button class="hvr-rectangle-in" type="submit">تعيين كلمة المرور</button>
        {{ csrf_field() }}
    </form>
</div>  
@stop