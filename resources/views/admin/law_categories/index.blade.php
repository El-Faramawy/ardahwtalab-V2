@extends('admin.index')
@section('title') الأقسام @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span>
					- الأقسام</h4>
			</div>

		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
				<li><a href="{{route('law_categories.index')}}">الأقسام</a></li>
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
						<th>نوع القسم</th>
						<th>التكلفة</th>
						<th>عدد المحامين</th>
						<th>عدد الطلبات</th>
						<th>تعديل</th>
						<th>حذف</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($rows as $info)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $info->name }}</td>
						<td>{{ $info->parent->name ?? 'رئيسي' }}</td>
						<td>{{ $info->cost }}</td>
						<td>{{ $info->lawyers()->count() }}</td>
						<td>{{ $info->lawsuits()->count() }}</td>
						<td><a class="btn btn-primary fa fa-pencil"
								href="{{route('law_categories.edit',$info->id)}}"></a></td>
						<td>
							<a class="btn btn-danger fa fa-remove" data-table='law_categories'
								data-id='{{$info->id}}'></a>
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
