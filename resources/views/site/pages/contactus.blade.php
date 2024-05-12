@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/contactus.css")}}">
@endpush
@section('title') اتصل بنا @stop
@section('page')
<div class="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact-send">
                    <h3>أرسل استفسارك</h3>
                    <form novalidate class="phi-form" method="POST">
                        @if(Session::has('true'))
                        <div class="alert alert-success">تم ارسال الرسالة بنجاح</div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger">كلمة التحقق غير متطابقة</div>
                        @endif
                        <p>البريد الإلكتروني</p>
                        <input id="field2" required dir="auto" type="email" value="" name="email">
                        <p>الغرض من الرسالة</p>
                        <div class="categories extra">
                            <select class="selectpicker" required id="field3" name="purpose" rel="f4">
                                <option>  اتصال عام</option>
                                <option>  طلب خاص</option>
                                <option>  شكوى</option>
                                <option>  اقتراح</option>
                            </select>
                        </div>
                        <p>أهمية الإتصال</p>
                        <div class="categories extra">
                            <select class="selectpicker" name="important">
                                <option selected>عادي</option>
                                <option>  متوسط</option>
                                <option>  هام</option>
                            </select>
                        </div>
                        <p>موضوع الرسالة</p>
                        <input id="field1" dir="rtl" type="text" value="" required name="subject">
                        <p>نص الرسالة</p>
                        <textarea dir="auto" id="field8" name="msg" rows="5"></textarea>
                        <div class="phi-form-row">
                            <label> التحقق من الصورة </label>
                            <div class="phi-form-item  ">
                                <div class="phi-form-captcha">
                                    {!!html_entity_decode(captcha_img('flat'))!!}
                                    <input id="field_captcha"  required 
                                           type="text" name="captcha" 
                                           placeholder="رجاءاً أدخل الحروف والأرقام الظاهرة فى الصورة ." 
                                           class="mws-textinput">
                                </div>
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit">إرسال </button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-info">
                    <h3>معلومات التواصل</h3>
                    <ul id="conlist" class="list-unstyled">
                        <?php 
//                        dd($contacts->toArray());
                        
                        ?>
                        
                        @foreach($contacts as $key=>$ct)
                        <?php
                        $href = $ct->value;
                        $href = get_contact_url($ct);
                        
                        ?>
                        <li><a href="{{$href}}">
                                <i class="{{contactIcons()[$ct->type]}}">
                                </i>
                                <span dir="auto">
                                    {{$ct->class}}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <?php
                    /*
                      <ul class="list-unstyled">
                      <li><a href=""><i class="fab fa-home"></i>الرياض - المملكة العربية السعودية</a></li>
                      <li><a href=""><i class="fab fa-phone"></i>0000-000-0000</a></li>
                      <li><a href=""><i class="fab fa-envelope"></i>info@thamen.com</a></li>
                      <li><a href=""><i class="fab fa-twitter"></i>twitter.com/thamen</a></li>
                      <li><a href=""><i class="fab fa-instagram"></i>instagram.com/thamen</a></li>
                      <li><a href=""><i class="fab fa-snapchat-ghost"></i>snapchat.com/thamen</a></li>
                      </ul>
                     */
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
@stop