@extends('admin.index')
@section('title') فورمه التوثيق @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">
		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> الفورمه التوثيق</span></h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin.documentation.index')}}">عرض الفورم</a></li>
					<li> {{$info->name}} </li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form class="form-horizontal">
						<fieldset class="content-group">
							<legend class="text-bold">القسم</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">اسم </label>
								<div class="col-lg-10">
									<div class="input-group">
										{!! $info->name !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">القسم </label>
								<div class="col-lg-10">
									<div class="input-group">
										{!! $info->catgeory->title ?? '' !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">رقم الوثيقه </label>
								<div class="col-lg-10">
									<div class="input-group">
										{!! $info->documentation_number !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">معلومات إضافيه</label>
								<div class="col-lg-10">
									<div class="input-group">
									        {!! $info->info !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">الصوره</label>
    								<div class="images_div">
    								    <div class="col-lg-10">
    										<div>
    										    @if(!is_null($info->image))
        											<img src="{{ url($info->image) }}" alt="{{$info->name}}">
    										    @endif
    										</div>
    									</div>
    								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<!-- /input group addons -->
		</div>
		<!-- /content area -->
	</div>
	<!-- /content wrapper -->
@stop
