@extends('admin.index')
@section('title')إرسال إشعارات @stop
@section('page')
<!-- Main content -->
	<div class="content-wrapper">
		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الإشعارات</span> </h4>
				</div>
			</div>
			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li>الإشعارات</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->
		<!-- Content area -->
		<div class="content">
			<!-- Input group addons -->
			<div class="panel panel-flat table-responsive">
				<div class="panel-body">
					<form action="{{ route('admin.notifcation.store') }}" class="form-horizontal" method="post">
						@if(Session::has('error'))
						<div class="alert alert-warning">{{Session::get('error')}}</div>
						@elseif(Session::has('true'))
						<div class="alert alert-success">تم إرسال بنجاح</div>
						@endif
						<fieldset class="content-group">
							<legend class="text-bold">الإشعار</legend>
							<div class="form-group">
								<label class="control-label col-lg-2">الرساله الإشعار</label>
								<div class="col-lg-10">
									<div class="input-group">

										<textarea name="message" required class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2">المستخدمين</label>
								<div class="col-lg-10">
									<div class="input-group">

										<select name="user_id[]" multiple class="selectpicker form-control" data-live-search="true">
											<option value="0">إختيار الكل</option>
											@foreach($users as $user)
											    <option value="{{$user->id}}">{{$user->username}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							{{ csrf_field() }}
						</fieldset>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">إرسال<i class="icon-arrow-left13 position-right"></i></button>
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
