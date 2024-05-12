@extends('site.user.profile')
@section('ptitle') تعديل كلمة المرور @stop
@section('part')
	<div class="col-sm-8 col-lg-9">
		<div class="profile-body">
			<p class="profile-h">تغيير كلمة المرور</p>
			{{ Form::model($info,['route'=>['users.update',$info->id],'class'=>'profile-setting-form','method'=>'put']) }}
				<div class="groub-div">
					<label for="name">كلمة المرور القديمة</label>
					{{ Form::password('old-password',old('old-password'),['placeholder'=>'كلمة المرور القديمة','required'=>'required']) }}
				</div>

				<div class="groub-div">
					<label for="name">كلمة المرور الجديدة</label>
					{{ Form::password('password',old('password'),['placeholder'=>'إعادة كلمة المرور','required'=>'required']) }}
				</div>

				<div class="groub-div">
					<label for="name">إعادة كلمة المرور الجديدة</label>
					{{ Form::password('confirm-password',old('confirm-password'),['placeholder'=>'إعادة كلمة المرور','required'=>'required']) }}
				</div>

				<button class="setting-submit  hvr-rectangle-in" type="submit">حفظ التغييرات</button>
			{{ Form::close() }}
		</div>
	</div>
@stop