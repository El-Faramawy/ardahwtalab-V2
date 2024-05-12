@extends('admin.index')
@section('title') تعديل قسم @stop
@section('page')
<style type="text/css">
	.kv-file-content {
		background: #409240;
	}
</style>
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الأقسام</span> - تعديل قسم
				</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('depts.index')}}">الأقسام</a></li>
				<li>تعديل قسم</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('depts.update',$info->id) }}" class="form-horizontal" method="post"
					enctype="multipart/form-data" files>
					{{ method_field('PUT') }}
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">القسم</legend>

						<div class="form-group">
							<label class="control-label col-lg-2">اسم القسم</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="text" value="{{$info->name}}" required class="form-control" name="name">
								</div>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-lg-2">نوع القسم</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select class="form-control selectpicker" data-live-search="true" name="parent_id" id="">
										<option value="0">قسم رئيسى</option>
										@foreach(\App\Models\Depts::get() as $dept)
										<option {{ $info->parent_id == $dept->id ? 'selected' : '' }} value="{{ $dept->id }}">
											{{ $dept->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">نظام المزادات</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select class="form-control" name="home" id="">
										<option value="1">نعم</option>
										<option {{ !$info->home ? 'selected' : '' }} value="0">لا</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">السعر</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select class="form-control" name="slider" id="">
										<option value="1">نعم</option>
										<option {{ !$info->slider ? 'selected' : '' }} value="0">لا</option>
									</select>
								</div>
							</div>
						</div>

							<div class="form-group">
								<label class="control-label col-lg-2">الصورة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input data-file="{{url('/').$info->image}}" type="file" id="uploadfile"
											class="form-control" name="image">
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
