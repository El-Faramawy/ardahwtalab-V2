@extends('admin.index')
@section('title') الإعلانات @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">
			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - الإعلانات</h4>
					</div>
				</div>
				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a href="{{route('advs.index')}}">الاشتراكات</a></li>
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
								<th>العنوان</th>
							    <th>الوصف</th>
							    <th>السعر</th>
							    <th>المده</th>
							    <th>الحالة</th>
							    <th></th>
							</tr>
						</thead>
						<tbody>
						    @if(isset($subscriptions->first()->id))

						    @foreach($subscriptions as $subscription)
							<tr>
								<td>{{ $subscription->title }}</td>
								<td>{!! $subscription->description !!}</td>
								<td>{{ $subscription->price }}</td>
								<td>{{ $subscription->duration }}</td>
								<td><input type="checkbox" {{ $subscription->active == "1" ? "checked" : "" }} disabled /></td>
								<td>
								    <a class="btn btn-success" href="{{ route('admin.subscription.edit' , ['subscription' => $subscription->id ]) }}">تعديل</a>
								    <a class="btn btn-danger" href="{{ route('admin.subscription.delete' , ['subscription' => $subscription->id ]) }}">حذف</a>
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<!-- /basic initialization -->
			</div>
			<!-- /content area -->
		</div>
		<!-- /main content -->
@stop
