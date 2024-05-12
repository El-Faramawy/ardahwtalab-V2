@extends('admin.index')
@section('title') الخصائص @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - الخصائص</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('props.index')}}">الخصائص</a></li>
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
					<br />
					<center>
						<a href="{{route('props.create')}}" class="btn btn-primary">
							اضافة خاصية جديدة
						</a>
						<a href="{{route('titles.create')}}" class="btn btn-success">
							اضافة عنوان خصائص
						</a>
					</center>
					<table class="table datatable-key-basic normal-table">
						<thead>
							<tr>
								<th>#</th>
								<th>الأيقونة</th>
								<th>الاسم</th>
								<th>العنوان</th>
								<th>النوع</th>
								<th>تعديل</th>
								<th>حذف</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; $thisdept=''; ?>
							@foreach($props as $info)
							@if($info->dept_id != $thisdept)
							<tr>
								<th style="text-align: center; font-size: 17px; font-weight: bold; background: #26A69A; color:#fff;" colspan="7">{{ \App\Models\Depts::find($info->dept_id)->name }}</th>
							</tr>
							@endif
							<tr>
								<td>{{ $i++ }}</td>
								<td><i class="fa {{ $info->icon }}"></i></td>
								<td>{{ $info->name }}</td>
								<td>
									@if($info->title)
									{{ $info->title->name}}
										<a href="{{ route('titles.edit' , $info->title->id) }}">
											<i class="fa fa-pencil"></i>
										</a>
									@endif
								</td>
								<td>{{ $info->main ? "رئيسى" : "اختياري" }}</td>
								<!-- <td><a class="btn @if($info->main) btn-success @endif fa fa-home" href="{{route('props.edit',$info->id)}}?type=main"></a></td> -->
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('props.edit',$info->id)}}"></a></td>
								<td>
									<a class="btn btn-danger fa fa-remove" data-table='proprites' data-id='{{$info->id}}'></a>
								</td>
							</tr>
							<?php $thisdept=$info->dept_id; ?>
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
