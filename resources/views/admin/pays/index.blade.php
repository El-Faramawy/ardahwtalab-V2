@extends('admin.index')
@section('title') أخر المدفوعات @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - أخر المدفو </h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a>أخر المدفو </a></li>
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
				<div class="panel panel-flat table-responsive">
					<table class="table datatable-key-basic">
						<thead>
							<tr>
								<th>#</th>
								<th>المستخدم</th>
								<th>طريقة الدفع</th>
								<th>تاريخ الارسال</th>
								<th>عرض</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($pays as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>
									<a target="blank" href="{{route('users.show',$info->user->username)}}">
										{{ $info->user->username }}
									</a>
								</td>
								<td>{{ $info->getbank->name }}</td>
								<td>{{ $info->send_date }}</td>
								<td><a class="btn btn-primary fa fa-eye" href="{{route('pays',['view'=>$info->id])}}"></a></td>
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
