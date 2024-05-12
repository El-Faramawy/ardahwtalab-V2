@extends('admin.index')
@section('title') اضافة نوع عملية @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">أنواع العمليلت</span> - اضافة نوع عملية</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('operations.index')}}">أنواع العمليلت</a></li>
					<li>اضافة نوع عملية</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('operations.store') }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">النوع عملية</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم الخدمة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="name">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">حدد خصائص الخدمة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select name="props[]" class="form-control" multiple>
											<option value="peroid">مدة التجهيز</option>
											<option value="price">السعر</option>
											<option value="start_price">فتح المزاد بمبلغ</option>
											<option value="end_date">تاريخ انهاء المزاد</option>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">عرض اعﻻنات الخدمة فى الصفحة الرئيسية</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input class="switches" type="checkbox" value="1" name="home">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">عدد الاعﻻنات فى الرئيسية</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="number" required class="form-control" name="home_num">
									</div>
								</div>
							</div>

							{{ csrf_field() }}
						</fieldset>

						<div class="text-right">
							<button type="submit" class="btn btn-primary">حفظ<i class="icon-arrow-left13 position-right"></i></button>
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
