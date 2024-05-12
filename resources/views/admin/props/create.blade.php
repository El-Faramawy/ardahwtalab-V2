@extends('admin.index')
@section('title') اضافة خاصية @stop
@section('page')
@push('assets')
	<link rel="stylesheet" href="{{ url('iconpicker/fontawesome-iconpicker.min.css') }}">
@endpush
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الخصائص</span> - اضافة
					خاصية</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('props.index')}}">الخصائص</a></li>
				<li>اضافة خاصية</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('props.store') }}" class="form-horizontal" method="post"
					enctype="multipart/form-data" files>
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">الخاصية</legend>

						<div class="form-group">
							<label class="control-label col-lg-2">اسم الخاصية</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="text" required class="form-control" name="name">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">الايقونة</label>
							<div class="col-lg-10">
								<div class="input-group">
									<input name="icon" class="fafa-icon form-control" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">نوع الخاصية</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select name="main" id="" class="form-control">
										<option value="0">اختيارى</option>
										<option value="1">رئيسى</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">القسم</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select required class="form-control" name="dept_id" data-live-search="true"
										id="dept_titles" data-action="{{route('admin.gettitles')}}">
										<option disabled selected>اختر القسم</option>
										@foreach($depts as $d)
										<option value="{{$d->id}}">{{$d->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<input type="hidden" name="parent" value="0">
						<div class="form-group">
							<label class="control-label col-lg-2">نوع الخاصية</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select class="norselect form-control" name="title_id">

									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">طريقة العرض</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select class="form-control" name="input">
										<option value="select">اختيارى (select)</option>
										<option value="input">مُدخل (input)</option>
									</select>
								</div>
							</div>
						</div>


						<div class="propContent">
							<div class="form-group myprops">
								<label class="control-label col-lg-2">انواع الخاصية</label>
								<div class="col-lg-10">
									<div class="input-group">
										<div class="row">
											<div class="col-sm-6">
												<input type="text" name="props[]" class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="file" name="images[]">
											</div>
											<div class="col-sm-1">
												<span class="btn btn-danger fa fa-trash"></span>
											</div>
										</div>
									</div>
									<div class="other-props"></div>
								</div>
							</div>

							<a class="btn btn-danger add-other-props">
								+ اضافة نوع اخر
							</a>
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

@push('scripts')
	<script src="{{ url('iconpicker/fontawesome-iconpicker.min.js') }}"></script>
	<script>
		$('.fafa-icon').iconpicker();
	</script>
@endpush
