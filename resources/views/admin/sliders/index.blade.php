@extends('admin.index')
@section('title') شرائح السليدر الرئيسية @stop
@section('page')
<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span> - شرائح السليدر الرئيسية</h4>
            </div>

        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
                <li><a>شرائح السليدر الرئيسية</a></li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    @if(Session::has('true'))
    <div class="alert alert-success">تم الاضافة بنجاح</div>
    @endif
    @if(Session::has('destroy-true'))
    <div class="alert alert-success">تم الحذف بنجاح</div>
    @endif
    <!-- Content sliders -->
    <div class="content">
        <!-- Basic initialization -->
        <div class="panel panel-flat table-responsive">
            <table class="table datatable-key-basic">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الرابط</th>
                        <th>تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($sliders as $info)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $info->title }}</td>
                        <td>{{ $info->link }}</td>
                        <td><a class="btn btn-primary fa fa-pencil" href="{{route('sliders.edit',$info->id)}}"></a>
                            <form action="{{route('sliders.destroy',$info->id)}}" method="post" style=" display: inline; ">
                                <input type="hidden" name="_method" value="DELETE"/>
                                    {{ csrf_field() }}
                                <button
                                    onclick="return confirm('هل انت متأكد من الحذف؟')"
                                    class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </form>


                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /basic initialization -->
    </div>
    <!-- /content sliders -->

</div>
<!-- /main content -->
@stop
