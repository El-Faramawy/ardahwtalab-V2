@extends('admin.index')
@section('title') الدعوات القضائية @stop
@section('page')



	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - الدعوات القضائية</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('lawsuits.index')}}">الدعوات القضائية</a></li>
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
								<th>رقم الطلب</th>
								<th>اسم المستخدم</th>
								<th>المنطقة </th>
								<th>قسم الطلب</th>
								<th>حالة الطلب</th>
								<th>المحامى المعين</th>
								@if(!request('lawyer_id'))
								<th>المحامين</th>
								@endif
								<th>عرض</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($rows as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->name ?? $info->user->username ?? '#' }}</td>
								<td>{{ $info->area->name ?? '#' }}</td>
								<td>{{ $info->category->name ?? 'أخري' }}</td>
								<td>{{ $info->my_status }}</td>
								<th>{{ $info->lawyer()->first()->fullname ?? '#' }}</th>
								@if(!request('lawyer_id'))
								<td><a class="btn btn-primary fa fa-list" href="{{ route('lawsuits.lawyers' , $info->id) }}"></a></td>
								@endif
								<td><a class="btn btn-success fa fa-eye show_lawsuit_details" data-href="{{ route('lawsuit.show' , $info->id) }}"></a></td>
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('lawsuits.edit',$info->id)}}"></a></td>
								<td>
									<a class="btn btn-danger fa fa-remove" data-table='lawsuits' data-id='{{$info->id}}'></a>
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
