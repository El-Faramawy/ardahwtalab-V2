@extends('admin.index')
@section('title') صفحة بداية الإعﻻن @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">صفحة بداية الإعﻻن</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>صفحة بداية الإعﻻن</a></li>
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
							<legend class="text-bold">صفحة بداية الإعﻻن</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">صفحة بداية الإعﻻن</label>
								<div class="col-lg-10">
									<div class="input-group">
										<input type="checkbox" name="start_page" class="swithcer" value="1" @if($info->start_page) checked @endif >
									</div>
								</div>
							</div>

							

							<div class="form-group">
								<label class="control-label col-lg-2">محتوى صفحة بداية الإعﻻن</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<textarea id="editor" rows="5" class="form-control" name="start_page_content">{{ $info->start_page_content }}</textarea>
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