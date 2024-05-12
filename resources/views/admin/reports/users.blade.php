@extends('admin.index')
@section('title')  تقارير المستخدمين  @stop
@section('page')
	<!-- Main content -->
        <div class="content-wrapper">

			<!-- Page header -->
			<div class="page-header">
				<div class="page-header-content">
					<div class="page-title">
						<h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> التقارير </span> -  المستخدمين </h4>
					</div>

				</div>

				<div class="breadcrumb-line">
					<ul class="breadcrumb">
						<li><a><i class="icon-home2 position-left"></i>التقارير</a></li>
						<li><a> المستخدمين </a></li>
                    </ul>
                    <div style=" position: absolute; left: 30px; ">
                        <form action="">
                            <input type="date" value="{{ request('from',date('Y-m-d')) }}" style="border: 0px;" name="from" id=""> -
                            <input type="date" value="{{ request('to',date('Y-m-d')) }}" style="border: 0px;" name="to" id="">
                            <input type="submit" class="btn btn-primary" value="بحث">
                        </form>
                    </div>
				</div>
            </div>

            <div class="content">
                @foreach ($data['counters'] as $item)
                    @include('admin.reports.layout.count',$item)
                @endforeach
            </div>

			<!-- Content area -->
			<div class="content">
				<!-- Basic initialization -->
				<div class="panel panel-flat table-responsive">
					<table class="table datatable-key-basic">
						<thead>
							<tr>
								<th>#</th>
								<th>المستخدم</th>
								<th>البريد</th>
								<th>الحاله</th>
								<th>عرض</th>
							</tr>
						</thead>
						<tbody>
                            <?php $index = 1;?>
                            @foreach ($data['lists'] as $user)
                                <tr>
                                    <td>{{ $index }} <?php $index++; ?></td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->block == 0)
                                            <span class="label label-warning">
                                                محزور
                                            </span>
                                        @else
                                            @if($user->active == 1)
                                                <span class="label label-success">
                                                    مفعل
                                                </span>
                                            @else
                                                <span class="label label-primary">
                                                    غير مفعل
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary fa fa-pencil" href="{{route('users.edit',$user->id)}}"></a>
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
