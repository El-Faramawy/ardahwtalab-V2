@extends('admin.index')
@section('title') اضافة صفحة @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span
						class="text-semibold">الصفحات</span> - اضافة صفحة</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('pages.index')}}">الصفحات</a></li>
				<li>اضافة صفحة</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('pages.store') }}" class="form-horizontal" method="post">
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">الصفحة</legend>

						<div class="form-group">
							<label class="control-label col-lg-2">عنوان الصفحة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="text" required class="form-control"
										name="title">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">رابط خارجى للصفحة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="link" class="form-control" name="link">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">عرض بالفوتر</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select name="footer" id="" class="form-control">
										<option value="0">لا</option>
										<option value="1">نعم</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">محتوى الصفحة</label>
							<div class="col-lg-10">
								<div class="input-group">
									<textarea id="editor" name="content"></textarea>
								</div>
							</div>
						</div>
						{{ csrf_field() }}
					</fieldset>

					<div class="text-right">
						<button type="submit" class="btn btn-primary">حفظ<i
								class="icon-arrow-left13 position-right"></i></button>
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
