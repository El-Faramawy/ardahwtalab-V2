@extends('site.user.profile')
@section('ptitle') الإعلانات المفضلة @stop
@section('part')
<link href="{{ url('/') }}/assets/harag/css/profile-fav-ads.css" rel="stylesheet">
<div class="col-sm-8 col-lg-9">
    <div class="row">
    <div class="profile-body">
        <p class="profile-h">الإعلانات المفضلة</p>
        @include('site.advs.loop')
    </div>
    </div>
</div>
@stop