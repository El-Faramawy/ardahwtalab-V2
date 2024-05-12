@extends('admin.index')
@section('title') اضافة قسم @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">أقسام المحاماة</span> -
					اضافة قسم</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('operations.index')}}">أقسام المحاماة</a></li>
				<li>اضافة قسم</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('law_categories.store') }}" class="form-horizontal" method="post">
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">

						<div class="form-group">
							<label class="control-label col-lg-2">اسم القسم</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="text" required class="form-control" name="name">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">نوع القسم</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select name="parent_id" class="form-control">
										<option hidden>قسم رئيسى</option>
										@foreach($rows as $cat)
											<option value="{{ $cat->id }}">{{ $cat->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">التكلفة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="number" required class="form-control" name="cost">
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