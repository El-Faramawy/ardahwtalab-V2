@extends('admin.index')
@section('title') العﻻمة المائية @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">العﻻمة المائية</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>العﻻمة المائية</a></li>
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
							<legend class="text-bold">نظام العمولة</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">طباعة الشعار على كل الصور</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" @if($info->watermark) checked @endif name="watermark" class="swithcer" value="1">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">مكان الشعار</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select class="form-control" name="watermark_position">
											@foreach(WatermarkPositions() as $key=>$wp)
											<option @if($key==$info->watermark_position) selected @endif value="{{$key}}">{{$wp}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">الشعار</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="file" id="uploadfile" name="watermark_image" @if($info->watermark_image) data-file="{{url('/').'/'.$info->watermark_image}}" @endif>
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