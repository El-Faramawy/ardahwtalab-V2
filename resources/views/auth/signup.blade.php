@extends('site.index') @section('title') تسجيل مستخدم @stop @section('page')
<div>
	<p class="form-h">تسجيل حساب جديد</p>
	<form novalidate class="modal-form" method="post" action="{{ route('signup') }}" enctype="multipart/form-data">
		<input value="{{old('username')}}" name="username" required type="text" placeholder="الاسم *" />
		<input value="{{old('phone')}}"  name="phone" pattern="(966|971|020)?([0-9]){2}([0-9]){7}" title="يجب ان يكون الرقم رقم جوال سعودى" required type="number" placeholder="رقم الهاتف *" min="8" />
		<input value="{{old('email')}}"  name="email" required type="email" placeholder="البريد الإلكترونى *" />
		<input name="password" required type="password" placeholder="كلمة السر *" />
		<input name="confirm-password" required type="password" placeholder="إعادة كلمة السر *" />
		<div class="input-div upload-div" style="width:100%">
			<input id="image-input" type="file" name="image" accept="image/*">
			<label for="image-input">
			    <font class="fontss def_text text_image"></font>
			    <span>اضافة صورة </span>
			</label>
		   </div>
		<button class="hvr-rectangle-in" type="submit">تسجيل</button>
		{{ csrf_field() }}
	</form>
	@if($policy)
	<p class="conditions">بتسجيلك على الموقع انت توافق على
		<a target="blank" href="{{ $policy->url }}">الشروط والأحكام</a>
	</p>
	@endif
</div>
@stop