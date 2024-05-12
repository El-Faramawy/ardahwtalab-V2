@extends('admin.index')
@section('title')  تقارير الإعلانات @stop
@section('page')
    <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold"> التقارير </span> -  الإعلانات </h4>
                    </div>

                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a><i class="icon-home2 position-left"></i>التقارير</a></li>
                        <li><a> الإعلانات </a></li>
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
                                <th>العنوان</th>
								<th>المعلن</th>
								<th>القسم</th>
								<th>المنطقة</th>
								<th>تاريخ الاضافة</th>
								<th>
                                    الحاله
                                </th>
								<th>مشاهدة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1;?>
                            @foreach ($data['lists'] as $info)
                                <tr>
                                    <td>{{ $index }} <?php $index++; ?></td>
                                    <td>{{ $info->title }}</td>
								    <td>
                                        <a target="blank" href="{{ route('users.show',\App\Models\User::find($info->user_id)->username) }}">
								    	    {{ $info->user->username or '' }}
                                        </a>
                                    </td>
                                    <td>{{ $info->getdept ? $info->getdept->name : '' }}</td>
                                    <td>{{ $info->getarea ? $info->getarea->name : '' }}</td>
                                    <td>{{ $info->created_at }}</td>
                                    <td>
                                        <?php
                                            $check = App\Models\Claims::where('advs_id', '=', $info->id)->first();
                                        ?>
                                        @if(!is_null($check))
                                            <span class="label label-warning">
                                                محزور
                                            </span>
                                        @else
                                            @if($info->active == 1)
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
                                    <td><a class="btn btn-primary fa fa-eye" target="blank" href="{{route('advertise.show',[$info->id,$info->slug])}}"></a></td>
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
