@extends('site.index')
@section('title') طلب ترقية عضوية  @stop
@section('page')
<div id="box-contents">
	<h1 class="box-contents-name">
		طلب ترقية عضوية 
	</h1>
	<div class="box-contents-content">
		<p class="bg-primary">
			للإطلاع على طُرق السداد<a ajax_open="true" href="{{ route('banking') }}"> أضغط هنا </a>
		</p>
		<form novalidate enctype="multipart/form-data" action="" id="myForm" method="POST">
			@if(Session::has('message'))
				<br />
				<div class="alert alert-success">{{ Session::get('message') }}</div>
			@endif
			@if(Session::has('error'))
				<br />
				<div class="alert alert-danger">{{ Session::get('error') }}</div>
			@endif
			<div class="phi-form-inline">
				<div class="phi-form-row">
					<label> الأشتراك المطلوب </label>
					<div class="phi-form-item">
						<select required id="field1" name="type" rel="f1">
							@foreach($joins as $jn)
								<option @if($jn->name==$type) selected @endif value="{{$jn->id}}">{{ $jn->name }}</option>
							@endforeach
						</select>


					</div>
				</div>
				<div class="phi-form-row">
					<label><font color="red">*</font> بيانات التحويل </label>
					<div class="phi-form-item">
						<textarea required id="field2" name="info" dir="rtl" cols="50" rows="5" class="south       LV_invalid_field" original-title="عند التأكد من بيانات التحويل سوف يتم ترقيت عضويتك فوراً من خلال إدارة الموقع"></textarea>			
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
				{{ csrf_field() }}
				<center>
					<input type="submit" class="set_data" value="إدخال البيانات">
				</center>
				</div>
			</form>
		</div>
		<div class="footer"></div>
	</div>

@stop