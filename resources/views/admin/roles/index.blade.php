@extends('admin.index')
@section('title') الصﻻحيات @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - الصﻻحيات</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('roles.index')}}">الصﻻحيات</a></li>
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
								<th>الصلاحيات</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($roles as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->name }}</td>
								<td>
									<?php $roles=explode(',',$info->roles); ?>
									@foreach($roles as $r)
                                                                            @if(isset(AdminRoles()[$r]))
										<li>{{ AdminRoles()[$r] }}</li>
                                                                                @endif
									@endforeach
								</td>
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('roles.edit',$info->id)}}"></a></td>
								<td>
									<a class="btn btn-danger fa fa-remove" data-table='roles' data-id='{{$info->id}}'></a>
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
