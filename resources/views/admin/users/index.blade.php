@extends('admin.index')

@section('title') المستخدمين @stop

@section('page')

    <!-- Main content -->

    <div class="content-wrapper">
        <!-- Page header -->

        <div class="page-header">

            <div class="page-header-content">

                <div class="page-title">

                    <h4><i class="icon-arrow-right6 position-right"></i> <span
                                class="text-semibold">اعدادات التطبيق</span> - المستخدمين</h4>

                </div>


            </div>


            <div class="breadcrumb-line">

                <ul class="breadcrumb">

                    <li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>

                    <li><a href="{{route('users.index')}}">المستخدمين</a></li>

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

                        <th>الاسم</th>

                        <th>الجوال</th>

                        <th>البريد الإلكترونى</th>

                        <th>الصﻻحية</th>

                        <th>القائمة السوداء</th>
                        <th>تفعيل</th>
                        <th>عرض الوثيقة وتفعيلها</th>
                        <th>تعديل</th>

                        <th>حذف</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php $i = 1; ?>

                    @foreach($users as $info)

                        <tr>

                            <td>{{ $i++ }}</td>

                            <td>{{ $info->username }}</td>

                            <td>{{ is_null($info->phone) ? '----' : $info->phone }}</td>

                            <td>{{ $info->email }}</td>

                            <td>

                                {{ $info->role_id ?\App\Models\Roles::find($info->role_id)->name : 'مستخدم' }}

                            </td>

                            <td><a class="btn btn-danger fa fa-lock"
                                   href="{{route('admin.users.edit',$info->id)}}?process=blacklist"></a></td>
                            <td>
                                <a class="btn btn-warning fa @if($info->active) fa-check-circle @else fa-check-circle-o @endif"
                                   href="{{route('admin.users.edit',$info->id)}}?process=active"></a>
                            </td>

                            <td>
                                @if(!is_null($info->documentation))
                                    <a href="{{route('admin.documentation.show',$info->documentation->id)}}">
                                        عرض
                                    </a>
                                    /
                                    @if($info->documentation->activeted == 0)
                                        <a class="btn btn-primary"
                                           href="{{route('documentation.activeted',$info->documentation->id)}}">
                                            تفعيل
                                        </a>
                                    @else
                                        مفـــعل
                                    @endif
                                @else
                                    لم بتم التوثيق بعد
                                @endif
                            </td>
                            <td><a class="btn btn-primary fa fa-pencil" href="{{route('admin.users.edit',$info->id)}}"></a>
                            </td>
                            @if($info->role_id != "1")
                                <td>

                                    <a class="btn btn-danger fa fa-remove" data-table='users'
                                       data-id='{{$info->id}}'></a>

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
