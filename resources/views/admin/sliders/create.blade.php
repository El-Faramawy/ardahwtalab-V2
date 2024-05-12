@extends('admin.index')
@section('title') اضافة شرائح السليدر الرئيسية @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">شرائح السليدر الرئيسية</span> - اضافة شرائح السليدر الرئيسية</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('sliders.index')}}">شرائح السليدر الرئيسية</a></li>
					<li>اضافة شرائح السليدر الرئيسية</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content sliders -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('sliders.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">الشرائح السليدر الرئيسية</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">العنوان</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="title">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">الرابط</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="link">
									</div>
								</div>
							</div>


							<div class="form-group">
								<label class="control-label col-lg-2">الصورة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="file" name="image" id="uploadfile">
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
		<!-- /content sliders -->

	</div>
	<!-- /content wrapper -->
@stop
