@extends('admin.index')
@section('title') تقارير العموله @stop
@section('page')
	<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - تقارير العمولة</h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
						<li><a>تقارير العمولة </a></li>
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
								<th>الإعلان</th>
								<th>المستخدم</th>
								<th>السعر</th>
								<th>تاريخ الارسال</th>
							</tr>
						</thead>
						<tbody>
						    @foreach($lists as $list)
							<tr>
							    <td>
							        @if(!is_null($list->adv))
    							        <a href="{{ route('advertise.show',[$list->adv->id,$list->adv->slug]) }}">{{ $list->adv->title }}</a>
							        @endif
							    </td>
							    <td>
							        
							        @if(!is_null($list->user))
    							        <a href="{{ route('users.edit',$list->user->id) }}">{{ $list->user->username }}</a>
							        @endif
							        </td>
							    <td>{{ $list->price }}</td>
							    <td>{{ $list->created_at }}</td>
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