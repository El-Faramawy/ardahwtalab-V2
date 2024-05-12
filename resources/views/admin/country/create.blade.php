@extends('admin.index')
@section('title') اضافة دولة @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الدول</span> - اضافة دولة</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('country.index')}}">الدول</a></li>
					<li>اضافة دولة</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content country -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('country.store') }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">الدولة</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم الدولة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" required class="form-control" name="name">
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
		<!-- /content country -->

	</div>
	<!-- /content wrapper -->
@stop
