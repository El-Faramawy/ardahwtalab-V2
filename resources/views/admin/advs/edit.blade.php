@extends('admin.index')
@section('title') تعديل إعلان @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">
	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الإعلانات</span> - تعديل
					إعلان</h4>
			</div>
		</div>
		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="{{route('advs.index')}}">الإعلانات</a></li>
				<li>تعديل إعلان</li>
			</ul>
		</div>
	</div>
	<!-- /page header -->
	<!-- Content area -->
	<div class="content">
		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form action="{{ route('advs.update',$info->id) }}" class="form-horizontal" method="post"
					enctype="multipart/form-data" files>
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					<fieldset class="content-group">
						<legend class="text-bold">إضافة إعلان</legend>
						<div class="form-group">
							<label class="control-label col-lg-2">القسم</label>
							<div class="col-lg-10">
								<div class="input-group">

									<select required class="form-control selectpicker advs_dept_id" data-live-search="true"
										name="dept" id="advs_dept_id" data-action="{{route('getDetails')}}" title="اختر القسم">
										@foreach($depts as $dp)
										<option {{ $info->super_dept->id == $dp->id ? 'selected' : '' }} @if($info->dept==$dp->id)
											selected @endif value="{{$dp->id}}">{{$dp->name}}
										</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="advs_details">
							@if(isset($advs_details))
							@foreach($advs_details as $adt)
							@foreach($adt as $key=>$ad)
							@if($key != 'others' && $key!= 'type')
							@if($adt['type']=='input')
							<div class="form-group">
								<label class="control-label col-lg-2">{{$key}}</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input required value="{{$ad}}" type="text" name="{{$key}}" class="form-control">
									</div>
								</div>
							</div>
							@else
							<div class="form-group">
								<label class="control-label col-lg-2">{{$key}}</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select required class="form-control proptype" name="{{$key}}">
											@foreach($adt['others'] as $ot)
											<option @if($ot->name==$ad) selected @endif value="{{$ot->name}}">
												{{ $ot->name }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							@endif
							@endif
							@endforeach
							@endforeach
							@endif
						</div>

						{{ method_field('PUT') }}
						<div class="advs_proptypes">
							@if(isset($advs_proptypes))
							@foreach($advs_proptypes as $adt)
							@foreach($adt as $key=>$ad)
							@if($key != 'others' && $key!= 'type')
							@if($adt['type']=='input')
							<div class="form-group">
								<label class="control-label col-lg-2">{{$key}}</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input required value="{{$ad}}" type="text" name="{{$key}}" class="form-control">
									</div>
								</div>
							</div>
							@else
							<div class="form-group">
								<label class="control-label col-lg-2">{{$key}}</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select required class="form-control" name="{{$key}}">
											@foreach($adt['others'] as $ot)
											<option @if($ot->name==$ad) selected @endif value="{{$ot->name}}">
												{{ $ot->name }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							@endif
							@endif
							@endforeach
							@endforeach
							@endif
						</div>
						<div class="form-group">

							<label class="control-label col-lg-2">حالة المنتج</label>

							<div class="col-lg-10">

								<div class="input-group">



									<select required class="form-control" name="status">
										<option>جديد</option>
										<option {{ $info->status=="مستعمل" ? 'selected' : '' }}>مستعمل</option>
									</select>

								</div>

							</div>

						</div>

						<div class="type_details">
							@if(isset($type_details))
							@foreach($type_details as $adt)
							@foreach($adt as $key=>$ad)
							<div class="form-group">
								<label class="control-label col-lg-2">{{ $type_keys[$key] }}</label>
								<div class="col-lg-10">
									<div class="input-group">

										<input value="{{$ad}}" type="text" name="{{$key}}" class="form-control">
									</div>
								</div>
							</div>
							@endforeach
							@endforeach
							@endif
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">عنوان الإعلان</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input required value="{{$info->title}}" type="text" name="title" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">المواصفات</label>
							<div class="col-lg-10">
								<div class="input-group">

									<textarea rows="5" required class="form-control" name="description">{{ $info->description }}
										</textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">الكلمات الدالة</label>
							<div class="col-lg-10">
								<div class="input-group">

									<input name="keywords" value="{{$info->keywords}}" id="tags" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">اضافة صور أخرى</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-addon fa"></span>
									<input type="file" id="multi-uploadfile" multiple class="form-control" name="images[]">
								</div>
								<div class="images_div">
									@foreach($info->images as $image)
									<div class="col-sm-2">
										<div>
											<a class="btn btn-danger fa fa-remove" data-table='images'
												data-id='{{$image->id}}'></a>
											<img src="{{ url($image->image) }}" alt="">
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">المنطقة</label>
							<div class="col-lg-10">
								<div class="col-sm-6">
									<div class="input-group">

										<select required data-live-search="true" class="form-control" name="country" id="country">
											@foreach($country as $ct)
											<option @if($info->country==$ct->id) selected @endif value="{{$ct->id}}">{{$ct->name}}
											</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group area_content">

										<select required class="form-control" name="area" id="area">
											@foreach($area as $ar)
											<option value="{{$ar->id}}" @if($ar->id==$info->area) selected @endif > {{$ar->name}}
											</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
						</script>
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
@push('scripts')
<script>
	get_dept_props("{{ $info->super_dept->id }}" , "{{ $info->id }}")
</script>
@endpush
@stop
