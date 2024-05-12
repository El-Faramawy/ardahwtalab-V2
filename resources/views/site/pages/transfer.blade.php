@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/transfer.css")}}">
<link rel="stylesheet" href="{{asset("thamen/lib/datepicker/dist/datepicker.min.css")}}">
@endpush
@push('scripts')
<script src="{{asset('thamen/lib/datepicker/dist/datepicker.js')}}"></script>
<script src="{{asset('thamen/lib/datepicker/i18n/datepicker.ar-AR.js')}}"></script>
<script type="text/javascript">
$('#send_date').datepicker({
    language: 'ar-AR'
});
</script>
@endpush
@section('title') أرسال معلومات عملية تحويل @stop
@section('page')
<div class="contact">
    <div class="container">
        <form novalidate enctype="multipart/form-data" action="" id="myForm" method="POST">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="contact-send">
                        <h3>تأكيد التحويل</h3>
                        <p>الاسم بالكامل</p>
                        <input id="field1" required name="name" dir="auto" type="text" value="">
                        <p>طريقة التحويل</p>
                        <div class="categories extra">
                            <select class="selectpicker" name="bank">
                                @foreach($banks as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p>تاريخ الإرسال</p>
                        <input 
                        <?php /* type="date" */ ?>
                            type="text"
                            autocomplete="off"
                            required 
                            id="send_date"
                            placeholder="mm/dd/yyyy"
                            class="calender" 
                            name="send_date">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="other">
                        <p style="margin-bottom:5px">رقم الحوالة</p>
                        <input style="margin-bottom:10px;" id="field1" required name="transaction_number" class="form-control" dir="auto" type="text" value="">
                        <p>ملاحظات</p>
                        <textarea id="field8" name="notes" dir="auto"></textarea>
                    </div>

                </div>
                {{ csrf_field() }}
                <button type="submit">ارسال البيانات</button>
            </div>
        </form>
    </div>
</div>
@stop