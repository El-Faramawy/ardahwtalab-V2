@extends('admin.index')
@section('title') محامين الدعوي @stop
@section('page')
<style>
.bootstrap-select.btn-group.show-tick .dropdown-menu li.selected a span.check-mark{
    margin-top:unset;
    top:25%;
}
</style>
<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-arrow-right6 position-right"></i> <span class="text-semibold">اعدادات التطبيق</span>
                    - محامين الدعوي</h4>
            </div>

        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a><i class="icon-home2 position-left"></i> اعدادات التطبيق</a></li>
                <li><a href="#!">محامين الدعوي</a></li>
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
            <br>
            <center>
            <a href="#!" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus"></i>
                ارسال إشعار تعيين للمحامين
            </a>
            </center>
            <table class="table datatable-key-basic">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المحامى</th>
                        <th>وقت الطلب</th>
                        <th>حالة الطلب</th>
                        @if(in_array($lawsuit->status , ['pending' , 'wait_lawyer_approve']))
                        <th>تعيين المحامى</th>
                        <th>اتعاب المحامى</th>
                        <th>النسبة فى حالة ربح القضية</th>
                        <th>رد المحامى</th>
                        @endif
                        <th>حذف الطلب</th>
                        @if(in_array($lawsuit->status , ['pending' , 'wait_lawyer_approve']))
                        <th>إختيار محامى</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach($lawsuit->lawyers as $info)
                    <tr style="background:{{ $info->pivot->approved ? '#a9dfa9' : '' }}">
                        <td>{{ $i++ }}</td>
                        <td>{{ $info->fullname ?? '#' }}</td>
                        <td>{{ $info->pivot->created_at ?? '#' }}</td>
                        <td>{{ trans('status.'.$info->pivot->status) ?? '#' }}</td>
                        @if(in_array($lawsuit->status , ['pending' , 'wait_lawyer_approve']))
                        <td>
                            @if($info->pivot->status == 'accepted')
                            <!--<a class="btn btn-success fa fa-check-circle-o" href="{{ route('approve_lawyer' , $info->pivot->id) }}"></a>-->
                            <a class="btn btn-success fa fa-check-circle-o" href=""></a>
                            @endif
                        </td>
                        <td>
                            @if($info->pivot->status == 'accepted')
                                {{\DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->where('lawyer_id', $info->id)->first()->fees}}
                            @endif
                        </td>
                        <td>
                            @if($info->pivot->status == 'accepted')
                                {{\DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->where('lawyer_id', $info->id)->first()->percentage}}
                            @endif
                        </td>
                        <td>
                            @if($info->pivot->status == 'accepted')
                                <a class="btn btn-success fa fa-eye show_lawsuit_details" data-href="{{ route('lawsuit_lawyer_show_admin' , ['lawsuit'=>$lawsuit->id,'lawyer'=>$info->id ]) }}"></a>
                            @endif
                        </td>
                        @endif
                        <td>
                            <a class="btn btn-danger fa fa-remove" data-table='lawsuit_lawyer'
                                data-id='{{$info->pivot->id}}'></a>
                        </td>
                        @if(in_array($lawsuit->status , ['pending' , 'wait_lawyer_approve']))
                        <td>
                            @if($info->pivot->status == 'accepted')
                                @if(\DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->where('lawyer_id', $info->id)->first()->choose == 0)
                                    <a class="btn btn-warning fa  fa-check-circle" title="لم يتم الإختيار بعد" href="{{ route('choose_lawyer' , \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->where('lawyer_id', $info->id)->first()->id) }}"></a>
                                @else
                                    <a class="btn btn-warning" title="تم الإختيار" href="{{ route('un_choose_lawyer' , \DB::table('lawsuit_lawyer')->where('lawsuit_id', $lawsuit->id)->where('lawyer_id', $info->id)->first()->id) }}">X</a>
                                @endif
                            @endif
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">تعيين محامين للطلب</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <select name="country" class="form-control" id="countryy" title="إختر الدوله">
                            <option selected disabled>أختر الدولة</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group area_content">
                        <select name="area" class="form-control" id="areaa" title="إختر المنظقة">
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="lawyers[]" multiple class="form-control" id="lawyerss" title="اختيار المحامين">
                            
                        @foreach($lawyers as $item)
                        <option value="{{$item->id}}">{{$item->fullname}}</option>
                        @endforeach
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">تعيين المحامين</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@stop

@push('scripts')
    <script>
        $(document).ready(function(){
        	$('#countryy').change(function(){
        		var country=$(this).val();
        		var action = "{{ url('/') }}/admin/getDetailss?country="+country;
        		$.get(action,function(data){
        			$('#areaa').html(data);
        		});
        	});
        	$('#areaa').change(function(){
        		var area=$(this).val();
        		var action = "{{ url('/') }}/admin/getDetailss?area="+area;
        		$.get(action,function(data){
        			$('#lawyerss').html(data);
        		});
        	});
        });
    </script>
@endpush
