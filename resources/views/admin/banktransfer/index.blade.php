@extends('admin.index')
@section('title') أنظمة الدفع @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

	<!-- Page header -->
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> التحويلات البنكيه </span>
				</h4>
			</div>

		</div>


	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Basic initialization -->
		<div class="panel panel-flat table-responsive">
			<table class="table datatable-key-basic">
				<thead>
					<tr>
						<th>#</th>
						<th>الاسم</th>
						<th>رقم الحوالة</th>
						<th>البنك</th>
						<th>تاريخ الإرسال</th>
						<th>الملاحظات</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($pays as $info)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ $info->name }}</td>
						<td>{{ $info->transaction_number }}</td>
						<td>{{ $info->getbank->name ?? '#' }}</td>
						<td>{{ $info->send_date }}</td>
						<td>{{ $info->notes }}</td>
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