@extends('site.index')
@section('title') @yield('ptitle') @stop
@section('page')
<!-- start profile section -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-lg-3">
                <div class="side-menu-div">
                    <ul class="side-menu">
                       
                        <li><a href="{{ route('users.edit',Auth::user()->username) }}">تعديل الحساب</a></li>
                        <li><a href="{{ route('user.notfs') }}">الإشعارات</a></li>
                        <li><a href="{{ route('users.chat') }}">الرسائل</a></li>
                        <li><a href="{{ route('users.advs') }}">إعلاناتى</a></li>
                        <li><a href="{{ route('likes') }}">الإعلانات المفضلة</a></li>
                        <li><a href="{{ route('logout') }}">تسجيل الخروج</a></li>
                    </ul>
                </div>
            </div>
            @yield('part')
        </div>
    </div>
</section>
<!-- end profile section -->

@stop