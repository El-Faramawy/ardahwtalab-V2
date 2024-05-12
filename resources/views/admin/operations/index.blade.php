@extends('admin.index')
@section('title') الخدمات @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - الخدمات</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('operations.index')}}">الخدمات</a></li>
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
								<th>الاسم</th>
								<th>الخصائص</th>
								<th>عرض بالرئيسية</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($operations as $info)
							<?php $props=explode(',', $info->props); ?>
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->name }}</td>
								<td>
									@if(in_array('peroid',$props))
									<li>مدة التجهيز</li>
									@endif
									@if(in_array('price',$props))
									<li>السعر</li>
									@endif
									@if(in_array('start_price',$props))
									<li>فتح المزاد بمبلغ</li>
									@endif
									@if(in_array('end_date',$props))
									<li>تاريخ انهاء المزاد</li>
									@endif
								</td>
								<td>@if($info->home) نعم @else ﻻ @endif</td>
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('operations.edit',$info->id)}}"></a></td>
								<td>
									<a class="btn btn-danger fa fa-remove" data-table='operations' data-id='{{$info->id}}'></a>
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
