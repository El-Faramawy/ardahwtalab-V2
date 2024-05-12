@extends('admin.index')
@section('title') اعدادات البردي الإلكترونى  @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات البردي الإلكترونى</span></h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a href="{{route('admin')}}"><i></i> الرئيسية</a></li>
					<li><a>اعدادات البردي الإلكترونى</a></li>
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
							<legend class="text-bold">اعدادات البردي الإلكترونى</legend>

							<div class="form-group">
								<label class="control-label col-lg-2">اسم المرسل</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->sender}}" name="sender" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">المزود (Driver)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select name="driver" class="form-control">
											@foreach(mail_data()->drivers as $md)
												<option @if($info->driver==$md) selected @endif >{{$md}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">المضيف (host)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->host}}" name="host" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">البريد الإلكترونى</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->email}}" name="email" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">كلمة المرور</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="" value="{{$info->password}}" name="password" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">منفذ بورت (port)</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<input type="text" value="{{$info->port}}" name="port" class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-lg-2">التشفير</label>
								<div class="col-lg-10">
									<div class="input-group">
										<span class="input-group-addon fa fa-meta"></span>
										<select class="form-control" name="encryption">
											@foreach(mail_data()->enc as $me)
											<option @if($me==$info->encryption) selected @endif >
												{{ $me }}
											</option>
											@endforeach
										</select>
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