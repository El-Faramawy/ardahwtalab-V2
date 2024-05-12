@extends('admin.index')
@section('title') اضافة مساحة اعﻻنية @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">المساحات الاعﻻنية</span> - اضافة مساحة اعﻻنية</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('posters.index')}}">المساحات الاعﻻنية</a></li>
					<li>اضافة مساحة اعﻻنية</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content posters -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('posters.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">المساحة اعﻻنية</legend>

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
								<label class="control-label col-lg-2">المكان</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select class="form-control" name="position">
											@foreach(positions() as $key=>$ps)
											<option value="{{$key}}">
												{{ $ps }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">صورة الاعﻻن</label>
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
		<!-- /content posters -->

	</div>
	<!-- /content wrapper -->
@stop
