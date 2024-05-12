@extends('admin.index')

@section('title') الاشتراكات  @stop

@section('page')

	<!-- Main content -->

		<div class="content-wrapper">
			<!-- Page header -->

			<div class="page-header">

				<div class="page-header-content">

					<div class="page-title">

						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> الاشتراكات الخاصة </span> - استعراض</h4>

					</div>



				</div>



			

			</div>

			<!-- /page header -->



		

			<!-- Content area -->

			<div class="content">

				<!-- Basic initialization -->

				<div class="panel panel-flat table-responsive table-scroll">

					<table class="table datatable-key-basic">

						<thead>

							<tr>

								<th>#</th>

								<th class="fixed-side">عنوان الاشتراك</th>

								<th>السعر </th>
								<th>المدة - عدد الاشهر</th>
								<th>وصف قصير</th>
								<th>الحالة</th>
								<th>تعديل</th>
								<th>حذف</th>

							</tr>

						</thead>

						<tbody>

							<?php $i=1; ?>

							@foreach($rows as $info)

							<tr>

								<td>{{ $i++ }}</td>

								<td class="fixed-side">{{ $info->title }}</td>

								<td>{{ $info->price }}</td>

								<td>{{ $info->time }}</td>
                            	<td>{{ $info->descr }}</td>
								<td>
									@if($info->active != 1)
									<!--<a class="btn btn-success fa fa-check-circle-o" href="admin/members/{{$info->id}}?process=active"></a>-->
									غير مفعل
									@else
									مُفعل
									@endif
								</td>
						

								<td><a class="btn btn-primary fa fa-pencil" href="../members/edit/{{$info->id}}"></a></td>

								<td>

									<a class="btn btn-danger fa fa-remove"  href='../members/remove/{{$info->id}}'></a>

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