@extends('site.index')
@section('title') تسجيل دخول محامى@stop
@section('page')
<div>
    <p class="form-h">تسجيل دخول محامى</p>
    @include('validate')
    <form novalidate class="modal-form" method="post" action="{{ route('lawyer_login') }}">
        <input name="email" required type="text" placeholder="البريد الإلكترونى " />
        <input name="password" required type="password" placeholder="كلمة السر" />
        <button class="hvr-rectangle-in" type="submit">دخول</button>
        {{ csrf_field() }}
    </form>
    <a class="side-link1" href="{{ route('lawyer_signup') }}">ليس لديك حساب؟</a>
</div>  
@stop