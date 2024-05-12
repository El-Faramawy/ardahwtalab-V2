@extends('admin.index')
@section('title') تحكم في رسالة اضافة الاعلان  @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span
						class="text-semibold">الاعلان</span> - رسالة الاضافة </h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('pages.index')}}">الاعلانات</a></li>
				<li> رسالة التنويه</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
	    @if(Session::has('true'))
			<div class="alert alert-success">تم التحديث بنجاح</div>
			@endif

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form  class="form-horizontal" method="post">
						<div class="form-group">
							<label class="control-label col-lg-2">الرسالة </label>
							<div class="col-lg-10">
								<div class="input-group">
									<textarea id="editor" name="content">{{ $data->message }}</textarea>
								</div>
							</div>
						</div>
						{{ csrf_field() }}
					</fieldset>

					<div class="text-right">
						<button type="submit" class="btn btn-primary">حفظ<i	class="icon-arrow-left13 position-right"></i></button>
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
