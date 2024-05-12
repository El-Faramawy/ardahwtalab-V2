@extends('admin.index')
@section('title') تعديل خاصية @stop
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
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الخصائص</span> - تعديل
					خاصية</h4>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('props.index')}}">الخصائص</a></li>
				<li>تعديل خاصية</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('props.update',$data->info->id) }}" class="form-horizontal" method="post"
					enctype="multipart/form-data" files>
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					{{method_field('PUT')}}
					<fieldset class="content-group">
						<legend class="text-bold">الخاصية</legend>

						<div class="form-group">
							<label class="control-label col-lg-2">اسم الخاصية</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input type="text" value="{{$data->info->name}}" required class="form-control"
										name="name">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">الايقونة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input value="{{ $data->info->icon }}" class="form-control fafa-icon" name="icon" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">نوع الخاصية</label>
							<div class="col-lg-10">
								<div class="input-group">
									<select name="main" id="" class="form-control">
										<option value="0">اختيارى</option>
										<option {{ $data->info->main ? 'selected' : '' }} value="1">رئيسى</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">القسم</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select required class="form-control" data-live-search="true" name="dept_id"
										data-live-search="true" id="dept_titles"
										data-action="{{route('gettitles')}}">
										@foreach($data->depts as $d)
										<option @if($d->id==$data->info->dept_id) selected @endif
											value="{{$d->id}}">{{$d->name}}</option>
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

									<select class="norselect form-control" name="title_id" data-live-search="true">
										@foreach($data->info->dept->titles as $title)
										<option @if($data->info->title && $data->info->title->id == $title->id) selected
											@endif value="{{$title->id}}">{{$title->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">طريقة العرض</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select class="form-control" name="input">
										<option @if($data->info->input=='select') selected @endif value="select">اختيارى
											(select)</option>
										<option @if($data->info->input=='input') selected @endif value="input">مُدخل
											(input)</option>
									</select>
								</div>
							</div>
						</div>

						<div class="propContent">
							@if(!isset($data->proptypes))
							<div class="form-group myprops">
								<label class="control-label col-lg-2">انواع الخاصية</label>
								<div class="col-lg-10">
									@foreach($data->propalltypes as $pl)
									<div class="input-group">
										<div class="row">
											<input type="hidden" name="ids[]" value="{{$pl->id}}">
											<div class="col-sm-6">
												<input type="text" value="{{$pl->name}}" name="props[]"
													class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="file" name="images[]">
											</div>
											<div class="col-sm-1">
												<span data-id="{{$pl->id}}" class="btn btn-danger fa fa-trash"></span>
											</div>
										</div>
									</div>
									@endforeach
									<div class="other-props"></div>
								</div>
							</div>
							<a class="btn btn-danger add-other-props" data-ids="11">
								+ اضافة نوع اخر
							</a>
							@else
							@foreach($data->proptypes as $p)
							<?php $thisprops=\App\PropTypes::where('parent',$p->id)->get(); ?>
							<div class="form-group myprops">
								<label class="control-label col-lg-2">{{$p->name}}</label>
								<div class="col-lg-10">
									@foreach($thisprops as $pt)
									<div class="input-group">
										<div class="row">
											<input type="hidden" name="ids[]" value="{{$pt->id}}">
											<input name="type[]" type="hidden" value="{{$p->id}}">
											<div class="col-sm-6">
												<input type="text" value="{{$pt->name}}" name="props[]"
													class="form-control">
											</div>
											<div class="col-sm-5">
												<input type="file" name="images[]">
											</div>
											<div class="col-sm-1">
												<span data-id="{{$pt->id}}" class="btn btn-danger fa fa-trash"></span>
											</div>
										</div>
									</div>
									@endforeach
									<div class="other-props-{{$p->id}}"></div><br />
									<a class="btn btn-danger add-other-props" data-parent="{{$p->id}}" data-ids="11">+
										اضافة نوع اخر</a>
								</div>
							</div>
							@endforeach
							@endif
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
	<input type="hidden" class="proptypes-action" value="{{route('proptypes.delete')}}">
</div>
<!-- /content wrapper -->
@stop

@push('scripts')
<script src="{{ url('iconpicker/fontawesome-iconpicker.min.js') }}"></script>
<script>
	$('.fafa-icon').iconpicker();
</script>
@endpush
