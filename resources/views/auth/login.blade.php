@extends('site.index')
@section('title') تسجيل الدخول @stop
@section('page')
<div>
    <p class="form-h">تسجيل دخول</p>
    <form novalidate class="modal-form" method="post" action="{{ route('login') }}" novalidate>
        <input name="username" required type="text" placeholder="البريد الإلكترونى أو رقم الهاتف" />
        <input name="password" required type="password" placeholder="كلمة السر" />
        <a class="forget-pass" href="{{url('password/reset')}}">هل نسيت كلمة السر؟</a>
        <button class="hvr-rectangle-in" type="submit">دخول</button>
        {{ csrf_field() }}
    </form>
    {{--<a class="side-link1" href="{{ route('signup') }}">ليس لديك حساب ؟</a><br>--}}
</div>
@stop
