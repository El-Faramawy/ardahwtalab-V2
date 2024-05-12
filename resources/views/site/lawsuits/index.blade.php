@extends('site.user.profile')
@section('ptitle') طلبات الوساطة القانونية @stop
@section('part')
<div class="col-sm-8 col-lg-9">
    <div class="profile-body">
        <h3>قائمة طلبات الوساطة القانونية</h3>
        <br>
        <table class="table responsive-table">
            <thead>
                <th>رقم الطلب</th>
                <th>الحالة</th>
                
                <th>إقتراح محاميين</th>
                
                <th>المنطقة</th>
                <th>تاريخ الإضافة</th>
                <th>عرض التفاصيل</th>
            </thead>
            <tbody>
                @foreach($rows as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->mystatus }}</td>
                    @if(!\DB::table('lawsuit_lawyer')->where('lawsuit_id', $row->id)->where('choose', 1)->where('approved', 1)->first())
                        <td>
                            <a href="#!" data-href="{{ route('lawsuit_lawyer_show' , $row->id) }}"
                                class="btn btn-primary show_lawsuit_details">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    @else
                    <td>
                        تم تعيين المحامى
                    </td>
                    @endif
                        
                    <td>{{ $row->area->name ?? '#' }}</td>
                    <td>{{ date('Y-m-d' , strtotime($row->created_at)) }}</td>
                    <td>
                        <a href="#!" data-href="{{ route('lawsuit.show' , $row->id) }}"
                            class="btn btn-primary show_lawsuit_details">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    @if($id = request('lawsuit_id'))
    <script>
        $(document).ready(function(){
            $.get("{{ route('lawsuit.show' , $id) }}" , function(result){
                $('#showModal .modal-body').html(result);
                $('#showModal').modal('lawsuit_lawyer_show');
            });
            $.get("{{ route('lawsuit_lawyer_show' , $id) }}" , function(result){
                $('#showModal .modal-body').html(result);
                $('#showModal').modal('lawsuit_lawyer_show');
            });
        });
    </script>
    @endif
@endpush
@stop