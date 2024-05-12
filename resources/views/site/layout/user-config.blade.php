<?php
$user = Auth::user();
$advs_buy = \App\Models\Advs::where(['user_id' => Auth::user()->id, 'type' => 3])->pluck('id')->toArray();
$advs_sale = \App\Models\Advs::where(['user_id' => Auth::user()->id, 'type' => 1])->pluck('id')->toArray();
$buy_requests = \App\Models\Requests::whereIn('advs_id', $advs_buy)->count();
$sale_requests = \App\Models\Requests::whereIn('advs_id', $advs_sale)->count();
$med_advs = \App\Models\Advs::where(['user_id' => Auth::user()->id])->pluck('id')->toArray();
$median_requests = \App\Models\Mediation::whereIn('advs_id', $med_advs)->count();
?>
@if(!$user->active)
<li>
    <a href="{{ route('users.active') }}" ajax_open="true">
        <i class="fa fa-check-circle"></i>
        تفعيل العضوية
    </a>
</li>
@endif
<li>
    <a href="{{ route('users.edit',$user->username) }}" ajax_open="true">
        <i class="fa fa-edit"></i>
        تعديل بياناتى
    </a>
</li>
<li>
    <a href="{{ route('users.edit',$user->username) }}?edit=password" ajax_open="true">
        <i class="fa fa-edit"></i>
        تعديل كلمة المرور
    </a>
</li>
@if($user->active)
<!--
<li>
        <i class="fa fa-arrow-right"></i>
        <a href="{{ route('users.requests','sale') }}" ajax_open="true">
                طلبات الشراء
                <span class="num">{{ $sale_requests }}</span>
        </a>
</li>
-->
<li>
    <a href="{{ route('users.timeline') }}" ajax_open="true" title="الخط الزمنى " class="south">
        <i class="fa fa-flag"></i>
        إعلانات الأعضاء المُتابعين
    </a>
</li>
<li>
    <a href="{{ route('users.follow') }}" ajax_open="true">
        <i class="fa fa-flag"></i>
        الأعضاء المُتابعين
    </a>
</li>
<li>

    <a href="{{ route('advertise.create') }}">
        <i class="fa fa-plus"></i>
        إضافة إعلان جديد
    </a>
</li>
<li>
    <a href="{{ route('users.advs','not-active') }}">
        <i class="far fa-circle"></i>
        إعلانات مرفوضة
    </a>
</li>
<li>
    <a href="{{ route('users.claims','advs') }}">
        <i class="far fa-circle"></i>
        إعلانات مبلغ عنها
    </a>
</li>
<li>
    <a href="{{ route('users.claims','comments') }}">
        <i class="far fa-comments"></i>
        تعليقات مبلغ عنها
    </a>
</li>
@endif
<li>
    <a href="{{ route('logout') }}">
        <i class="fas fa-sign-out-alt"></i>
        تسجيل الخروج
    </a>
</li>
