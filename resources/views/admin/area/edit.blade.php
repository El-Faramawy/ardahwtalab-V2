@extends('admin.index')
@section('title') تعديل منطقة @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">
		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">المناطق</span> - تعديل منطقة</h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('area.index')}}">المناطق</a></li>
					<li>تعديل منطقة</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('area.update',$info->id) }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						{{ method_field('PUT') }}
						<fieldset class="content-group">
							<legend class="text-bold">المنطقة</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">اسم المنطقة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" value="{{$info->name}}" required class="form-control" name="name">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">الدولة</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select name="country_id" class="selectpicker form-control" data-live-search="true">
											@foreach($country as $c)
											<option @if($info->country_id==$c->id) selected @endif value="{{$c->id}}">{{$c->name}}</option>
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
