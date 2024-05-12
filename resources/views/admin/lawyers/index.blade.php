@extends('admin.index')

@section('title') المحامين @stop

@section('page')

	<!-- Main content -->

		<div class="content-wrapper">
			<!-- Page header -->

			<div class="page-header">

				<div class="page-header-content">

					<div class="page-title">

						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - المحامين</h4>

					</div>



				</div>



				<div class="breadcrumb-line">

					<ul class="breadcrumb">

						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>

						<li><a href="{{route('lawyers.index')}}">المحامين</a></li>

					</ul>

				</div>

			</div>

			<!-- /page header -->



			@if(Session::has('true'))

			<div class="alert alert-success">تم الاضافة بنجاح</div>

			@endif

			<!-- Content area -->

			<div class="content">

				<!-- Basic initialization -->

				<div class="panel panel-flat table-responsive table-scroll">

					<table class="table datatable-key-basic">

						<thead>

							<tr>

								<th>#</th>

								<th class="fixed-side">الاسم</th>

								<th>البريد الإلكترونى</th>
								<th>الطلبات</th>
								<th>تفعيل</th>
								<th>حجب</th>
								<th>تعديل</th>

								<th>حذف</th>

							</tr>

						</thead>

						<tbody>

							<?php $i=1; ?>

							@foreach($rows as $info)

							<tr>

								<td>{{ $i++ }}</td>

								<td class="fixed-side">{{ $info->fullname }}</td>

								<td>{{ $info->email }}</td>

								<td>

									<a class="btn btn-danger fa fa-list" href="{{ route('lawsuits.index',['lawyer_id' => $info->id]) }}"></a>

								</td>

								<td>
									@if($info->status != 1)
									<a class="btn btn-success fa fa-check-circle-o" href="{{route('lawyers.edit',$info->id)}}?process=active"></a>
									@else
									مُفعل
									@endif
								</td>
								<td>
									@if($info->status == 1)
									<a class="btn btn-danger fa fa-lock" href="{{route('lawyers.edit',$info->id)}}?process=block"></a>
									@endif
								</td>

								<td><a class="btn btn-primary fa fa-pencil" href="{{route('lawyers.edit',$info->id)}}"></a></td>

								<td>

									<a class="btn btn-danger fa fa-remove" data-table='lawyers' data-id='{{$info->id}}'></a>

								</td>

							</tr>

							@endforeach

						</tbody>

					</table>

				</div>

				<!-- /basic initialization -->

			</div>

			<!-- /content area -->



		</div>

		<!-- /main content -->

@stop
