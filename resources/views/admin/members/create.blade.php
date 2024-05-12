@extends('admin.index')
@section('title') إضافة اشتراك      @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span
						class="text-semibold">الاشتراكات الخاصة</span> - الاضافة  </h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('pages.index')}}">الاشتراكات</a></li>
				<li> اضافة اشتراك </li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
	    @if(Session::has('message'))
			<div class="alert alert-success">تم  بنجاح</div>
			@endif

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form  class="form-horizontal" method="post">
						{{ csrf_field() }}

						<div class="form-group">

								<label class="control-label col-lg-2">عنوان الاشتراك </label>

								<div class="col-lg-10">

									<div class="input-group">
									<input type="text" required="" class="form-control" value="" name="title">
									</div>

								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-lg-2">السعر</label>

								<div class="col-lg-10">

									<div class="input-group">
									<input type="number" required="" min="1" class="form-control" value="" name="price">
									</div>

								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-lg-2">المدة - عدد الاشهر  </label>

								<div class="col-lg-10">

									<div class="input-group">
									<input type="number" required="" min="1" class="form-control" value="" name="time">
									</div>

								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-lg-2">وصف  قصير </label>

								<div class="col-lg-10">

									<div class="input-group">
									<input type="text" required="" class="form-control" value="" name="descr">
									</div>

								</div>

							</div>

					<div class="text-right">
						<button type="submit" class="btn btn-primary">حفظ<i	class="icon-arrow-left13 position-right"></i></button>
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
