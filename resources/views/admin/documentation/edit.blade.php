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
					<form action="{{ route('admin.documentation.update',$info->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						{{ method_field('PUT') }}
						<fieldset class="content-group">
							<legend class="text-bold">القسم</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">اسم </label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" value="{{$info->name}}" required class="form-control" name="name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">رقم الوثيقه </label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="number" value="{{$info->documentation_number}}" required class="form-control" name="documentation_number">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">معلومات إضافيه</label>
								<div class="col-lg-10">
									<div class="input-group">

										<textarea name="info" required class="form-control">{{ $info->info }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">الصوره</label>
        							<div class="col-lg-10">
        								<div class="input-group">
        									<span class="input-group-addon fa"></span>
        									<input type="file" class="form-control" name="image">
        								</div>
        							</div>
    								<div class="images_div">
    								    <div class="col-sm-2">
    										<div>
    										    @if(!is_null($info->image))
        											<img src="{{ url($info->image) }}" alt="{{$info->name}}">
    										    @endif
    										</div>
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
