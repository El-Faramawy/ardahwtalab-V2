@extends('site.index')
@section('title'){{ $title }}@stop
@section('page')
<div>
   <p class="form-h">{{ $title }}</p>
   @include('validate')
   <form novalidate class="modal-form lawsuit_accept" method="post">
      <div class="form-group">
         <label class="radio-cont">
            <input type="checkbox" required name="go" value="1">
            <span class="checkmark"></span>
            وفق الشرح والمعطيات التي قدمها العميل ( مبدئياً ) فإنه يمكن السير في الدعوى
         </label>
      </div>
      <div class="form-group">
         <label class="radio-cont">
            <input type="checkbox" required name="allowed" value="1">
            <span class="checkmark"></span>
            بدراسة الطلب ( مبدئيا)يتبين أنه لا يحوي محذور شرعي
         </label>
      </div>
      <div class="form-group">
         <label class="radio-cont">
            <input type="checkbox" required name="accept" value="1">
            <span class="checkmark"></span>
            أوافق على استحقاق موقع عرض وطلب نسبة 2% من النسبة التي ستحصل من العميل في حال كسب القضية أو
            الطلب
         </label>
      </div>
      <ul>
         <li>
            <div class="form-group">
               <label for="">لتولي القضية مطلوب من العميل دفعة مقدمة مقدارها</label>
               <input type="number" required name="fees" id="">
            </div>
         </li>
         <li>
            <div class="form-group">
               <label for="">النسبة المستحقة على العميل في حال كسب الدعوى أو الطلب من إجمالي مبلغ الحكم أو الطلب
                  هي</label>
               <input type="number" required name="percentage" id=""> %
            </div>
         </li>
          <li>
            <div class="form-group">
               <label for="">ملاحظاتك</label>
               <textarea required name="notes" class="form-control" id=""> </textarea>
            </div>
         </li>
         
      </ul>
      @if(isset($data->files))
      <div class="form-group">
         <label class="radio-cont">
             تحميل الملفات : 
		        @foreach(json_decode($data->files) as $file)
		        <a download href="{{ $file }}" style="margin: 0 19px 0 46px;"><i class="fa fa-download"></i></a> 
		         @endforeach
		</label>
      </div>     
	 @endif
      <button class="hvr-rectangle-in" type="submit">إرسال</button>
      {{ csrf_field() }}
   </form>
</div>

@stop