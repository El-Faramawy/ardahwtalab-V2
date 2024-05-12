@extends('admin.index')
@section('title') وضع الصيانة @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">وضع الصيانة</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>وضع الصيانة</a></li>
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
							<legend class="text-bold">وضع الصيانة</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">وضع الصيانة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" name="close" class="swithcer" value="1" @if($info->close) checked @endif>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">رسالة الصيانة</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<textarea id="editor" rows="5" class="form-control" name="close_msg">{{ $info->close_msg }}</textarea>
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