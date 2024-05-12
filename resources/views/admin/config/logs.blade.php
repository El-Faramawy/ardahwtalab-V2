@extends('admin.index')
@section('title') تغير اسم الأدمن @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاعدادات العامة</span> - اعدادات الدخول</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>الاعداتا العامة</a></li>
					<li>اعدادات الدخول</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">الأسم</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">البريد الإلكترونى</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-user"></span>
										<input value="{{Auth::user()->email}}" type="text" class="form-control" name="email" placeholder="البريد الإلكترونى">
									</div>
								</div>
							</div>

							<legend class="text-bold">تغيير كلمة المرور</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">كلمة المرور القديمة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-lock"></span>
										<input type="password" class="form-control" name="old-password" placeholder="كلمة المرور القديمة">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">كلمة المرو الجديدة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-lock"></span>
										<input type="password" class="form-control" name="new-password" placeholder="كلمة المرور الجديدة">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">اعادة كلمة المرور الجديدة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-lock"></span>
										<input type="password" class="form-control" name="confirm-new-password" placeholder="اعادة كلمة المرور الجديدة">
									</div>
								</div>
							</div>
						</fieldset>

						{{ csrf_field() }}

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