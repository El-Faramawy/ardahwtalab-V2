@extends('admin.index')
@section('title') تعديل قسم @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">
		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الاقسام الفورمه التوثيق</span> - تعديل قسم</h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin.documentation.category.index')}}">اقسام الفورمه</a></li>
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
					<form action="{{ route('admin.documentation.category.update',$info->id) }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						{{ method_field('PUT') }}
						<fieldset class="content-group">
							<legend class="text-bold">القسم</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">اسم القسم</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" value="{{$info->title}}" required class="form-control" name="title">
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
