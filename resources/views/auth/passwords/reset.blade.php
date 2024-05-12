@extends('site.index')
@section('title') استعادة كلمة المرور @stop
@section('page')

<div class="col-sm-8 col-lg-9">
    <div class="profile-body">
        <p class="profile-h">تغيير كلمة المرور</p>
        {{ Form::model($info,['route'=>['users.update',$info->id],'class'=>'profile-setting-form','method'=>'put' , 'novalidate' => 'novalidate']) }}
            <div class="groub-div">
                <label for="name">البريد الإلكترونى</label>
                {{ Form::email('email',old('email'),['placeholder'=>'البريد الإلكترونى','required'=>'required']) }}
            </div>

            <div class="groub-div">
                <label for="name">كلمة المرور الجديدة</label>
                <input type="password" name="password" required id="">
            </div>

            <div class="groub-div">
                <label for="name">إعادة كلمة المرور</label>
                <input type="password" name="password-confirmation" required id="">
            </div>

            <button class="setting-submit  hvr-rectangle-in" type="submit">تغيير كلمة المررو</button>
        {{ Form::close() }}
    </div>
</div>
@endsection
