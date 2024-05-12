@extends('admin.index')
@section('title') السليد شو @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">السليد شو</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>السليد شو</a></li>
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
							<legend class="text-bold">السليد شو</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">السليد شو</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" name="slide_show" class="swithcer" value="1" @if($info->slide_show) checked @endif >
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">عدد عناصر السليد شو</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="number" name="slide_show_items" class="form-control" value="{{$info->slide_show_items}}" >
									</div>
								</div>
							</div>



							<div class="form-group">
								<label class="control-label col-lg-2">الأقسام التى يتم عرضها</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select multiple class="form-control" name="slide_show_depts[]">
											@foreach(\App\Models\Depts::all() as $dp)
											<option @if(in_array($dp->name,explode(',',$info->slide_show_depts))) selected @endif>{{ $dp->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">نوع الاعﻻنات</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select class="form-control" name="slide_show_type">
											<option value="excellent" @if($info->slide_show_type=='excellent') selected @endif>الاعﻻنات المميزة</option>
											<option value="all" @if($info->slide_show_type=='all') selected @endif>كل الاعﻻنات</option>
										</select>
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
