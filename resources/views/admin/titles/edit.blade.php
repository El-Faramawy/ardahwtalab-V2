@extends('admin.index')
@section('title') تعديل عنوان الخصائص @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الخصائص</span> - تعديل عنوان الخصائص</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('props.index')}}">الخصائص</a></li>
					<li>تعديل عنوان الخصائص</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">

			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('titles.update',$data->info->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data" files>
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم التعديل بنجاح</div>
						@endif
						{{method_field('PUT')}}
						<fieldset class="content-group">
							<legend class="text-bold">عنوان الخصائص</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">الاسم</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input type="text" value="{{$data->info->name}}" required class="form-control" name="name">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">القسم</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select required class="form-control" data-live-search="true" name="dept_id" data-live-search="true" id="dept_titles" data-action="{{route('gettitles')}}">
											@foreach($data->depts as $d)
											<option @if($d->id==$data->info->dept_id) selected @endif value="{{$d->id}}">{{$d->name}}</option>
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
