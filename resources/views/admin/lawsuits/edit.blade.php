@extends('admin.index')
@section('title') تعديل طلب الوساطة @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">طلبات
						الوساطة القانونية</span> - تعديل طلب الوساطة</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('lawsuits.index')}}">طلبات الوساطة القانونية</a></li>
				<li>تعديل طلب الوساطة</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('lawsuits.update' , $info->id) }}" class="form-horizontal"
					method="post">
					{{ method_field('put') }}
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">طلب الوساطة</legend>
						<div class="form-group">
							<label class="control-label col-lg-2">المنطقة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select title="حدد المنطقة" name="area_id"
										class="form-control selectpicker"
										data-live-search="true">
										@foreach($areas as $area)
										<option {{ $area->id == $info->area_id ? 'selected' : '' }} value="{{ $area->id }}">{{ $area->name }}
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
								<input value="{{ $info->address }}" name="address" class="form-control">

								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">وصف الطلب</label>
							<div class="col-lg-10">
								<div class="input-group">

									<textarea rows="7" required class="form-control"
										name="content">{{ $info->content }}</textarea>
								</div>
							</div>
						</div>

												<div class="form-group">
							<label class="control-label col-lg-2">ملاحظات </label>
							<div class="col-lg-10">
								<div class="input-group">

									<textarea rows="7" required class="form-control" name="notes">{{ $info->notes }}</textarea>
								</div>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-lg-2">قسم الطلب</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select name="category_id" class="form-control">
										<option value="0" selected disabled>حدد قسم الطلب
										</option>
										@foreach($categories as $cat)
										<option {{ $info->category_id == $cat->id ? 'selected' : '' }}
											value="{{ $cat->id }}">{{ $cat->name }}
										</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>



							<div class="form-group">
							<label class="control-label col-lg-2">الملفات </label>
							<div class="col-lg-10">
								<div class="input-group">
								    @if(isset($info->files))
								      @foreach(json_decode($info->files) as $file)
								        <a download href="{{ $file }}"><i class="fa fa-download"></i></a>
								      @endforeach

								    @endif

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
