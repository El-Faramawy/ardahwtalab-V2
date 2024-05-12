@extends('admin.index')
@section('title') المناطق @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">
			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - المناطق</h4>
					</div>
				</div>
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a>المناطق</a></li>
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
					<a style="font-size:20px;" href="{{ route('area.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> إضافة منطقة</a>
					<table class="table datatable-key-basic">
						<thead>
							<tr>
								<th>#</th>
								<th>الاسم</th>
								<th>الدولة</th>
								<th>تاريخ الاضافة</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($area as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->name }}</td>
								<td>{{ App\Models\Country::find($info->country_id)->name }}</td>
								<td>{{ $info->created_at }}</td>
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('area.edit',$info->id)}}"></a></td>
								<td>
									@if($info->id!=8)
									<a class="btn btn-danger fa fa-remove" data-table='area' data-id='{{$info->id}}'></a>
									@endif
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
