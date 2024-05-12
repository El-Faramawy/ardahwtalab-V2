@extends('admin.index')
@section('title') الرئيسية @stop
@section('page')
	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header">
			<div class="page-header-content">
				<div class="page-title">
					<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">لوحة التحكم</span> - الرئيسية</h4>
				</div>
			</div>

			<div class="breadcrumb-line">
				<ul class="breadcrumb">
					<li><a><i class="icon-home2 position-left"></i> لوحة التحكم</a></li>
					<li class="active">الرئيسية</li>
				</ul>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content homepage">
			<div class="row">
				<div class="col-sm-6">
					<h4 class="title">أخر الاعلانات</h4>
					<table class="table datatable-key-basic">
						<thead>
							<th>العنوان</th>
							<th>المستخدم</th>
						</thead>
						<tbody>
							@foreach($advs as $ad)
								<tr>
									<td><a href="{{route('advs.show',$ad->id)}}">{{$ad->title}}</a></td>
									<td><a target="blank" href="{{route('users.show',$ad->user->username)}}">
										{{ $ad->user->username }}
									</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<a class="a-nav" href="{{ route('advs.index',['type'=>'active']) }}">
						المزيد ...
					</a>
				</div>

				<div class="col-sm-6">
					<h4 class="title">طلبات تفعيل الاعلانات</h4>
					<table class="table datatable-key-basic">
						<thead>
							<th>العنوان</th>
							<th>المستخدم</th>
						</thead>
						<tbody>
							@foreach($not_advs as $ad)
								<tr>
									<td><a href="{{route('advs.show',$ad->id)}}">{{$ad->title}}</a></td>
									<td><a target="blank" href="{{route('users.show',$ad->user->username)}}">
										{{ $ad->user->username }}
									</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<a class="a-nav" href="{{ route('advs.index',['type'=>'not-active']) }}">
						المزيد ...
					</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<h4 class="title">المستخدمين الأحدث</h4>
					<table class="table datatable-key-basic">
						<thead>
							<th>الاسم</th>
							<th>تاريخ الاشتراك</th>
						</thead>
						<tbody>
							@foreach($users as $us)
								<tr>
									<td><a target="blank" href="{{route('users.show',$us->username)}}">
										{{ $us->username }}
									</a></td>
									<td>{{ $us->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<a class="a-nav" href="{{ route('users.index',['type'=>'active']) }}">
						المزيد ...
					</a>
				</div>	

				<div class="col-sm-6">
					<h4 class="title">المستخدمين الأكثر اعلانا</h4>
					<table class="table datatable-key-basic">
						<thead>
							<th>الاسم</th>
							<th>عدد الإعلانات</th>
						</thead>
						<tbody>
							@for($i=0;$i<count($most_users) && $i<5;$i++)
								<tr>
									<td><a target="blank" href="{{route('users.show',$most_users[$i]['username'])}}">
										{{ $most_users[$i]['username'] }}
									</a></td>
									<td>{{ $most_users[$i]['count'] }}</td>
								</tr>
							@endfor
						</tbody>
					</table>
					<a class="a-nav" href="{{ route('advs.index',['type'=>'active']) }}">
						المزيد ...
					</a>
				</div>				
			</div>
		</div>
		<!-- /content area -->

	</div>
	<!-- /main content -->
@stop