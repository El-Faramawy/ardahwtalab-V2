@extends('admin.index')
@section('title') طريقة العرض @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">طريقة العرض</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>طريقة العرض</a></li>
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
							<legend class="text-bold">طريقة العرض</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">عدد الاعﻻنات فى كل صفحة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" class="form-control" name="per_page" value="{{$info->per_page}}">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">طريقة عرض الصور فى صفحة الاعﻻن</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select class="form-control" name="images_show">
											<option @if($info->images_show=='slide') selected @endif value="slide">سﻻيد شو</option>
											<option @if($info->images_show=='full') selected @endif value="full">صور كاملة</option>
										</select>
									</div>
								</div>
							</div>

							<div class="title">حجم الصورة</div>
							<div class="form-group">
								<label class="control-label col-lg-2">أقصى عرض للصور</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" class="form-control" name="max_width" value="{{$info->max_width}}">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">أقصى ارتفاع</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" class="form-control" name="max_height" value="{{$info->max_height}}">
									</div>
								</div>
							</div>

							<div class="title">اعﻻنات اخرى للمستخدم</div>
							<div class="form-group">
								<label class="control-label col-lg-2">عرض اعﻻنات اخرى للمستخدم</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" class="switches" name="similar" value="1" @if($info->similar) checked @endif>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">عدد الاعﻻنات الاخرى للمستخدم</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" class="form-control" name="similar_num" value="{{$info->similar_num}}">
									</div>
								</div>
							</div>

							<div class="title">تحديث الاعﻻن</div>
							<div class="form-group">
								<label class="control-label col-lg-2">السماح للعضو بتحديث الاعﻻن</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" value="1" class="switches" name="update_ads" @if($info->update_ads) checked @endif>
									</div>
								</div>
							</div>

							<!-- <div class="form-group">
								<label class="control-label col-lg-2">المدة بين كل تحديث (دقيقة)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" class="form-control" name="update_after" value="{{$info->update_after}}" placeholder="عدد بالدقائق">
									</div>
								</div>
							</div> -->

							<div class="title">عدد الاعلانات اليومية للمستخدم</div>
							<div class="form-group">
								<label class="control-label col-lg-2">عدد الاعلانات</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="number" class="form-control" name="day_advs" value="{{$info->day_advs}}" placeholder="عدد الاعلانات اليومية للمستخدم">
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