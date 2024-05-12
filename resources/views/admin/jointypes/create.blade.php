@extends('admin.index')
@section('title') اضافة نظام اشتراك @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">أنظمة الاشتراك</span> - اضافة نظام اشتراك</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('jointypes.index')}}">أنظمة الاشتراك</a></li>
					<li>اضافة نظام اشتراك</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('jointypes.store') }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">النظام اشتراك</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم النظام</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="name">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">سعر الاشتراك</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="price">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">صﻻحيات النظام</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select name="rules[]" class="form-control" multiple>
											@foreach(joinRules() as $key=>$jr)
											<option value="{{$key}}">{{$jr}}</option>
											@endforeach
										</select>
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
		<!-- /content area -->

	</div>
	<!-- /content wrapper -->
@stop
