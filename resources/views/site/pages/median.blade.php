@extends('site.index')
@section('title') نموذج طلب الوساطه @stop
@section('page')
	<div id="box-contents">
		<h1 class="box-contents-name">
			إرسال أشعار وساطة
		</h1>
		<div class="box-contents-content">
			
			<div class="ckeditor-code "><p style="text-align:center">نتيح هذة الخدمة للحفاظ على حق المشترى والبائع خطوات وطريقة الوساطة</p>

				<ol>
					<li>تتفق بينك وبين البائع على الوساطة</li>
					<li>ترسل لنا أشعار بطلب الوساطة</li>
					<li>ترسل لنا المبلغ المتفق عليه</li>
					<li>يرسل لنا البائع السلعة المتفق عليها</li>
					<li>عند وصول المبلغ الذى ارسلته ووصول السلعة لنا سوف نقوم مباشرة بأرسال المبلغ للبائع وكذلك أرسال السلعة لك</li>
				</ol>
			</div>
			<form novalidate enctype="multipart/form-data" action="" id="myForm" method="POST">

				@if(Session::has('message'))
					<div class="alert alert-success">{{Session::get('message')}}</div>
					@endif
				@if(Session::has('error'))
				<div class="alert alert-warning">{{Session::get('error')}}</div>
				@endif
				<div class="phi-form-inline">
					<div class="phi-form-row">
						<label> رقم الإعلان </label>
						<div class="phi-form-item  "> 
							<input type="text" required name="advs_id" size="47" class="mws-textinput" value=""> 
						</div>
					</div>
					<div class="phi-form-row">
						<label> التحقق من الصورة </label>
						<div class="phi-form-item  ">
							<div class="phi-form-captcha"> 
								{!!html_entity_decode(captcha_img('flat'))!!}
								<input id="field_captcha"  required type="text" name="captcha" placeholder="رجاءاً أدخل الحروف والأرقام الظاهرة فى الصورة ." size="47" class="mws-textinput"> 
							</div>
						</div>
					</div>
					<center>
						<input type="submit" name="set_data" class="set_data" value="إرسال الأشعار">
					</center>
				</div> 
				{{ csrf_field() }}
			</form>
		</div>
		<div class="footer"></div>
	</div>
@Stop