@extends('site.index')
@section('title') استعادة كلمة المرور @stop
@section('page')
<div>
	<p class="form-h">نسيت كلمة المرور</p>
	<form novalidate class="modal-form" method="post" action="{{ route('password_reset') }}">
		<input name="email" required type="email" placeholder="البريد الإلكترونى *" />
		<button class="hvr-rectangle-in" type="submit">استعادة كلمة المرور</button>
		{{ csrf_field() }}
	</form>
</div>
@endsection
