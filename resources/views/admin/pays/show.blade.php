@extends('admin.index')
@section('title') تفاصيل الدفع @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - تفاصيل الدفع </h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a>تفاصيل الدفع </a></li>
					</ul>
				</div>
			</div>
			<!-- Content area -->
			<div class="content">
				<!-- Basic initialization -->
				<div class="panel panel-flat table-responsive">
					<table class="table datatable-key-basic">
						<tr>
							<th>رقم الطلب</th>
							<td>{{ $info->id }}</td>
						</tr>
						<tr>
							<th>المستخدم</th>
							<td>
								<a href="{{ route('users.show',$info->user->username) }}" target="blank"> {{ $info->user->username }}
								</a>
							</td>
						</tr>
						<tr>
							<th>طريقة الدفع</th>
							<td>{{ $info->getbank->name }}</td>
						</tr>
						<tr>
							<th>معلومات</th>
							<td><textarea disabled style="width: 100%; border: 0px; background:transparent;" rows="5">{{ $info->send_data }}</textarea></td>
						</tr>
						<tr>
							<th>ملاحظات</th>
							<td>{{ $info->notes }}</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- /page header -->
		</div>
@stop