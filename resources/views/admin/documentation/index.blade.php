@extends('admin.index')
@section('title')  فورمه التوثيق @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">
			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> -  فورمه التوثيق</h4>
					</div>
				</div>
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a> فورمه التوثيق</a></li>
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
								<th>الحساب</th>
								<th>القسم</th>
								<th>الاسم</th>
								<th>تاريخ الاضافة</th>
								<th>الحاله</th>
								<th>تفعيل الوثيقة</th>
								<th>مشاهده</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($lists as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->user->username ?? '' }}</td>
								<td>{{ $info->catgeory->title }}</td>
								<td>{{ $info->name }}</td>
								<td>{{ $info->created_at }}</td>
								<td>
								    @if($info->status == 0)
								        غير مشاهد
								    @else
								    مشاهد
								    @endif
								</td>
								<td>
								    @if($info->activeted == 0)
    								    <a class="btn btn-primary" href="{{route('admin.documentation.activeted',$info->id)}}">تفعيل</a>
								    @else
    								    <p>
    								        مفعل
    								    </p>
								    @endif
								</td>
								<td>
								    <a class="btn btn-primary fa fa-eye" href="{{route('admin.documentation.show',$info->id)}}"></a>
								</td>
								<td>
								    <a class="btn btn-primary fa fa-pencil" href="{{route('admin.documentation.edit',$info->id)}}"></a>
								</td>
								<td>
									<a class="btn btn-danger fa fa-remove" data-table='documentation_form' data-id='{{$info->id}}'></a>
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
