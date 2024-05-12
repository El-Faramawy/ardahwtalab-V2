@extends('admin.index')
@section('title') أخر الاعلانات المبلغ عنها @stop
@section('page')

	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - أخر الاعلانات المبلغ عنها</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('advs.index')}}?type=report">أخر الاعلانات المبلغ عنها</a></li>
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
								<th>الشاكى</th>
								<th>نص الشكوى</th>
								<th>التاريخ</th>
								<th>الاعلان</th>


							</tr>
						</thead>
						<tbody>

							<?php $i=1; ?>
							@foreach($claims as $info)
								<tr>
									<td>{{ $i++ }}</td>
									<td><a href="{{route('users.edit',$info->user->id)}}">{{ $info->user->username }}</a></td>
									<td>{{ $info->text }}</td>
									<td>{{ date('Y-m-d',strtotime($info->created_at)) }}</td>
									<td><a href="{{ route('advs.edit',$info->advs->id) }}">{{ $info->advs->title }} </a></td>

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
