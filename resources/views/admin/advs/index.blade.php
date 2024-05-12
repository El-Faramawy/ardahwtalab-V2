@extends('admin.index')
@section('title') الإعلانات @stop
@section('page')
@php

use Carbon\Carbon;

@endphp
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
						<li><a href="{{route('advs.index')}}">الإعلانات</a></li>
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
				<div class="panel panel-flat table-responsive" style="overflow-x:auto;">
					<table class="table datatable-key-basic">
						<thead>
							<tr>
								<th>#</th>
								<th>العنوان</th>
								<th>المعلن</th>
								<th>القسم</th>
								<th>المنطقة</th>
								<th>تاريخ الاضافة</th>
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<th>تاريخ ايقاف الاعلان</th>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<th>الاشتراك</th>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<th>سعر الاشتراك</th>
								@endif

    								<th>مشاهدة</th>
								@if(isset($_GET['type']) && $_GET['type'] != 'deleted')
    								<th>تفعيل</th>
								@endif

								{{-- <th>سليدر الرئيسية</th> --}}
								<th>تعديل</th>
								@if(isset($_GET['type']) && $_GET['type'] != 'deleted')
    								<th>حذف</th>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'deleted')
    								<th>تحميل الملف</th>
    								<th>إعاده النشر</th>
    								<th>حذف نهائي</th>
								@endif
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($advs as $info)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $info->title }}</td>
								<th><a target="blank" href="{{ route('users.show',\App\Models\User::find($info->user_id)->username) }}">
									{{ $info->user->username or '' }}
								</a></th>
								<td>{{ $info->getdept ? $info->getdept->name : '' }}</td>
								<td>{{ $info->getarea ? $info->getarea->name : '' }}</td>
								<td>{{ $info->created_at }}</td>
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<td>{{ Carbon::parse($info->created_at)->addHour($info->subscription->duration ?? 0) }}</td>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<td>{{ $info->subscription->title ?? "" }}</td>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'active')
    								<td>{{ $info->subscription->price ?? 0}}</td>
								@endif
    							<td><a class="btn btn-primary fa fa-eye" target="blank" href="{{route('advertise.show',[$info->id,$info->slug])}}"></a></td>
								@if(isset($_GET['type']) && $_GET['type'] != 'deleted')
    								<td><a class="btn @if($info->active) btn-warning @else btn-primary @endif fa fa-check" href="{{route('advs.show',$info->id)}}?process=active"></a></td>
								@endif

								{{-- <td><a class="btn @if($info->excellent) btn-warning @else btn-primary @endif fa fa-star" href="{{route('advs.show',$info->id)}}?process=excellent"></a></td> --}}
								<td><a class="btn btn-primary fa fa-pencil" href="{{route('advs.edit',$info->id)}}"></a></td>
								@if(isset($_GET['type']) && $_GET['type'] != 'deleted')
    								<td>
    									<a class="btn btn-danger fa fa-remove" data-table='advs' data-id='{{$info->id}}'></a>
    								</td>
								@endif
								@if(isset($_GET['type']) && $_GET['type'] == 'deleted')
    								<td>
    								     <?php $link = route('admin.advs.pdf',$info->id); ?>
    									<a class="btn btn-primary fa fa-download" onClick="MyWindow=window.open('{!! $link !!}','MyWindow','width=1000,height=500'); return false;"></a>
    								</td>
    								<td>
    									<a class="btn btn-primary fa fa-star" href="{{route('admin.advs.rePublic',$info->id)}}"></a>
    								</td>
    								<td>
    									<a class="btn btn-danger fa fa-remove" data-table='advs' data-id='{{$info->id}}'></a>
    								</td>
								@endif
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
