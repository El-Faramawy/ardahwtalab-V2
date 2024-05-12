@extends('admin.index')
@section('title') عن الموقع @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاعدادات العامة</span> - عن الموقع</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>الاعداتا العامة</a></li>
					<li>عن الموقع</li>
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
							<legend class="text-bold">عن الموقع</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">عنوان الموقع</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa"></span>
										<input type="text" class="form-control" name="title" value="{{$info->title}}" >
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">لوجو الموقع</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa"></span>
										<input type="file" data-file="{{url('/').$info->logo}}" id="uploadfile" class="form-control" name="logo">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">وصف الموقع</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<textarea rows="5" class="form-control" name="description">{{ $info->description }}</textarea>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">الكلمات الدﻻلية</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<textarea rows="5" class="form-control" name="meta">{{ $info->meta }}</textarea>
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