@extends('admin.index')

@section('title') تعديل صﻻحية @stop

@section('page')

<!-- Main content -->

	<div class="content-wrapper">



		<!-- Page header -->

		<div class="page-header">

			<div class="page-header-content">

				<div class="page-title">

					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">الصﻻحيات</span> - تعديل صﻻحية</h4>

				</div>

			</div>



			<div class="breadcrumb-line">

				<ul class="breadcrumb">

					<li><a href="{{route('roles.index')}}">الصﻻحيات</a></li>

					<li>تعديل صﻻحية</li>

				</ul>

			</div>

		</div>

		<!-- /page header -->





		<!-- Content area -->

		<div class="content">



			<!-- Input group addons -->

			<div class="panel panel-flat table-responsive">

				<div class="panel-body">

					<form action="{{ route('roles.update',$info->id) }}" class="form-horizontal" method="post">

						@if(Session::has('error'))

						<div class="alert alert-warning">{{Session::get('error')}}</div>

						@elseif(Session::has('true'))

						<div class="alert alert-success">تم التعديل بنجاح</div>

						@endif

						{{ method_field('PUT') }}
						<fieldset class="content-group">

							<legend class="text-bold">الصﻻحية</legend>

							<div class="form-group">

								<label class="control-label col-lg-2">اسم الصﻻحية</label>

								<div class="col-lg-10">

									<div class="input-group">



										<input value="{{$info->name}}" type="text" required class="form-control" name="name">

									</div>

								</div>

							</div>



							<div class="form-group">

								<label class="control-label col-lg-2">الصﻻحيات</label>

								<div class="col-lg-10">

									<div class="input-group">



										@foreach(AdminRoles() as $key=>$sr)

										<li>

											<input type="checkbox" name="roles[]" @if(in_array($key,$roles)) checked @endif value="{{$key}}"><span>{{$sr}}</span>

										</li>

										@endforeach

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
