@extends('admin.index')

@section('title') تعديل مستخدم @stop

@section('page')

<!-- Main content -->

	<div class="content-wrapper">



		<!-- Page header -->

		<div class="page-header">

			<div class="page-header-content">

				<div class="page-title">

					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">المستخدمين</span> - تعديل مستخدم</h4>

				</div>

			</div>



			<div class="breadcrumb-line">

				<ul class="breadcrumb">

					<li><a href="{{route('admin.users.index')}}">المستخدمين</a></li>

					<li>تعديل مستخدم</li>

				</ul>

			</div>

		</div>

		<!-- /page header -->





		<!-- Content area -->

		<div class="content">



			<!-- Input group addons -->

			<div class="panel panel-flat table-responsive">

				<div class="panel-body">

					<form action="{{ route('admin.users.update',$info->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">

						@if(Session::has('error'))

						<div class="alert alert-warning">{{Session::get('error')}}</div>

						@elseif(Session::has('true'))

						<div class="alert alert-success">تم التعديل بنجاح</div>

						@endif

						{{ method_field('PUT')	 }}

						<fieldset class="content-group">

							<legend class="text-bold">المستخدم</legend>



							<div class="form-group">

								<label class="control-label col-lg-2">اسم المستخدم</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input type="text" value="{{$info->username}}" required class="form-control" name="username">

									</div>

								</div>

							</div>



							<div class="form-group">

								<label class="control-label col-lg-2">صلاحية المستخدم </label>

								<div class="col-lg-10">

									<div class="input-group">



										<select required name="role_id" class="form-control">
											@if(!$info->role_id)
												<option selected value="null">مستخدم عادى</option>
											@else
												<option value="null">مستخدم عادى</option>
											@endif
											@foreach($roles as $c)
												<option @if($info->role_id==$c->id) selected @endif value="{{$c->id}}">{{$c->name}}</option>
											@endforeach

										</select>

									</div>

								</div>

							</div>



							<div class="form-group">

								<label class="control-label col-lg-2">الجوال</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input type="text" value="{{$info->phone}}" required class="form-control" name="phone">

									</div>

								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-lg-2">البريد الإلكترونى</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input type="email" value="{{$info->email}}" required class="form-control" name="email">

									</div>

								</div>

							</div>

							<div class="form-group">

								<label class="control-label col-lg-2">كلمة المرور</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input type="password" class="form-control" name="password">

									</div>

								</div>

							</div>



							<!--<div class="form-group">-->

							<!--	<label class="control-label col-lg-2">اعادة كلمة المرور</label>-->

							<!--	<div class="col-lg-10">-->

							<!--		<div class="input-group">-->



							<!--			<input type="password" class="form-control" name="confirm-password">-->

							<!--		</div>-->

							<!--	</div>-->

							<!--</div>-->



							<div class="form-group">

								<label class="control-label col-lg-2">الصورة</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input type="file" id="uploadfile" @if($info->image) data-file="{{$info->image}}" @endif class="form-control" name="image">

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
