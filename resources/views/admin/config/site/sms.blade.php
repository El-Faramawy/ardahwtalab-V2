@extends('admin.index')
@section('title') اعدادات بوابة sms @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات بوابة sms</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>اعدادات بوابة sms</a></li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form class="form-horizontal" method="post" enctype="multipart/form-data">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">اعدادات بوابة sms</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">بوابة الإرسال</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select class="selectpicker" name="package">
											@foreach(smsPackages() as $key=>$pk)
											<option value="{{$key}}">{{$pk}}</option @if($key==$info->package) selected @endif>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم الستخدم (username)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->username}}" name="username" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">كلمة المرور (password)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input value="{{$info->password}}" name="password" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم المرسل (sender)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input value="{{$info->sender}}" name="sender" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">مقدمة الرسالة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->welcome_msg}}" name="welcome_msg" class="form-control">
									</div>
								</div>
							</div>
							{{ csrf_field() }}
						</fieldset>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">تعديل<i class="icon-arrow-left13 position-right"></i></button>
						</div>
					</form>
				</div>
			</div>
			<!-- /input group addons -->

		</div>
		<!-- /content area -->

	</div>
	<!-- /content wrapper -->
@stop