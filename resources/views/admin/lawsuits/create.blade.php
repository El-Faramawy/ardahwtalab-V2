@extends('admin.index')
@section('title') اضافة طلب وساطة @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">طلبات
						الوساطة القانونية</span> - اضافة طلب وساطة</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('lawsuits.index')}}">طلبات الوساطة القانونية</a></li>
				<li>اضافة طلب وساطة</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('lawsuits.store') }}" class="form-horizontal" method="post">
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">طلب الوساطة </legend>

						<div class="form-group">
							<label class="control-label col-lg-2">المنطقة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select title="حدد المنطقة" name="area_id" class="form-control selectpicker" data-live-search="true">
										@foreach($areas as $area)
										<option value="{{ $area->id }}">{{ $area->name }}
										</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">العنوان</label>
							<div class="col-lg-10">
								<div class="input-group">
									<input name="address" class="form-control">

								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">وصف الطلب</label>
							<div class="col-lg-10">
								<div class="input-group">

									<textarea rows="7" required class="form-control"
										name="content"></textarea>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">قسم الطلب</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select title="حدد قسم الطلب" name="category_id" class="form-control selectpicker" data-live-search="true">
										@foreach($categories as $cat)
										<option value="{{ $cat->id }}">{{ $cat->name }}
										</option>
										@endforeach
									</select>
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
