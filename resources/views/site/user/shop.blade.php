@extends('site.index')
@section('title') تعديل متجرى @stop
@section('page')
	<!-- Content area -->
	<div class="content">

		<!-- Input group addons -->
		<div class="panel panel-flat table-responsive">
			<div class="panel-body">
				<form novalidate action="{{ route('users.update',$info->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
					@if(Session::has('error'))
					<div class="alert alert-warning">{{Session::get('error')}}</div>
					@elseif(Session::has('true'))
					<div class="alert alert-success">تم التعديل بنجاح</div>
					@endif
					{{ method_field('PUT')	 }}
					<fieldset class="content-group">
						<legend class="text-bold">تعديل بيانات متجرى</legend>
						<hr />
						<div class="form-group">
							<label class="control-label col-lg-2">اسم المتجر</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-addon fa fa-input"></span>
									<input type="text" value="{{$info->shop_name}}" required class="form-control" name="shop_name">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">وصف مختصر للمتجر</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-addon fa fa-input"></span>
									<input type="text" value="{{$info->shop_text}}" required class="form-control" name="shop_text">
								</div>
							</div>
						</div>


						<div class="form-group">
							<label class="control-label col-lg-2">الصورة</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-addon fa fa-input"></span>
									<input type="file" id="uploadfile" @if($info->image) data-file="{{url('/').$info->image}}" @endif class="form-control" name="image">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">الخلفية</label>
							<div class="col-lg-10">
								<div class="input-group">
									<span class="input-group-addon fa fa-input"></span>
									<input type="file" class="uploadfile form-control" @if($info->wallpaper) data-file="{{url('/').$info->wallpaper}}" @endif name="wallpaper">
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

@stop
