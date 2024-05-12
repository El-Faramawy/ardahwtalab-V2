<div class="overlay"></div>
<div class="load-page">
    <div class="loader">جاري التحميل ....</div>
</div>
<!-- Start Header -->
<div class="header">
    <div class="top-bar-sec">
        <div class="container">
            <div class="top-bar">
                <div class="right-nav">
                    <a href="{{ route('advertise.create') }}" class="fixall add-ad hvr-shutter-out-horizontal"><i
                            class="fas fa-tag"></i>اضف
                        اعلانك</a>




                        <a class="fixall menu-ico">
                            <i class="fas fa-bars"></i>
                            <span style=" font-size: 14px; margin-right: 4px; ">
                            الأقسام
                        </span>
                        </a>
                        <a href="#!" class="fixall search-ico"><i class="fas fa-search"></i></a>
                        @if(has_unseen_messages())
                            <a href="{{ route('users.chat') }}" class="fixall mail-ico active"><i
                                    class="fas fa-envelope-open"></i></a>
                        @else
                            <a href="{{ route('users.chat') }}" class="fixall mail-ico"><i class="fas fa-envelope"></i></a>
                        @endif

                        <a href="{{ route('user.notfs') }}"
                           class="fixall mail-ico {{ has_unseen_notfs() ? 'active' : '' }}"><i class="fas fa-bell"></i></a>


                        <div class="user-nav">


                          @if(Auth::check())
                                <a href="#!" class="fixall log">

                                    @if(!is_null(auth()->user()->documentation))
                                        @if(auth()->user()->documentation->activeted == 1)
                                            <i class="fa fa-star" style="color:green;"></i>
                                        @endif
                                    @endif

                                    {{ auth()->user()->username }}
                                </a>
                                <ul class="drop-menu list-unstyled">

                                    <li><a class="fixall" href="{{ route('users.edit',Auth::user()->username) }}"><i
                                                class="fa fa-cog"></i>تعديل الحساب</a></li>
                                    <li><a class="fixall" href="{{ route('user.notfs') }}"><i
                                                class="fa fa-bell"></i>الإشعارات</a></li>
                                    <li><a class="fixall" href="{{ route('users.chat') }}"><i
                                                class="fa fa-envelope"></i>الرسائل</a></li>
                                    <li><a class="fixall" href="{{ route('users.advs') }}"><i
                                                class="fa fa-th-large"></i>إعلاناتى</a></li>
                                    <li><a class="fixall" href="{{ route('likes') }}"><i class="fa fa-star"></i>الإعلانات
                                            المفضلة</a></li>

                                      @if(isset(auth()->user()->Expire_Date) )
                                      @php
                                      $now = strtotime(date('d-m-Y')); // or your date as well
                                      $your_date = strtotime(auth()->user()->Expire_Date);
                                      $datediff =  $your_date - $now;
                                      $days =  round($datediff / (60 * 60 * 24));
                                      if($days > 0){
                                      echo'
                                       <li><a class="fixall" href="'.url("members").'">
                                           بقي '.$days.' يوم  لأشتراكك
                                           </li>
                                           </a>
                                      ';
                                      }
                                      @endphp

                                      @endif
                                    <li><a class="fixall" href="{{ route('logout') }}"><i class="fa fa-lock"></i>تسجيل
                                            الخروج</a></li>
                                </ul>
                        @else
                                <a href="{{ route('login') }}" style="margin-left:5px" class="fixall log"> دخول </a>
                                <a href="{{ route('signup') }}" class="fixall log"> تسجيل </a>
                        @endif
                        </div>
                        @if(Auth::check())
                            &nbsp; &nbsp;
                            @if(isset(auth()->user()->Expire_Date) )
                                @php
                                    $now = strtotime(date('d-m-Y')); // or your date as well
                                    $your_date = strtotime(auth()->user()->Expire_Date);
                                    $datediff =  $your_date - $now;
                                    $days =  round($datediff / (60 * 60 * 24));
                                    if($days > 0){
                                    echo'
                                        <a class="fixall" style="color:#580707" href="'.url("members").'">
                                         بقي '.$days.' يوم  لأشتراكك
                                         </a>
                                    ';

                                    }else{
                                         echo'
                                          <a class="fixall" style="color:#580707" href="'.url("members").'">
                                         اشتراك
                                         </a>
                                    ';
                                    }
                                @endphp
                            @else
                                <a class="fixall" style="color:#580707" href="{{url("members")}}">
                                    اشتراك
                                </a>
                            @endif
                        @endif


                </div>
                <a href="{{ url('/') }}" class="logo"><img src="{{ layout_data()->config->logo }}"
                                                           class="img-responsive"></a>
            </div>
        </div>
    </div>
    <div class="sec-bar-sec">
        <div class="container">
            <form novalidate class="sec-bar" action="{{ route('search') }}">
                <input required type="text" value="{{ request('keyword') }}" name="keyword"
                       placeholder="أدخل رقم الإعلان أو كلمة البحث" class="fixall search-input"
                       placeholder="عن ماذا تبحث ؟">
                <select title="اختر المدينة" value="{{ request('keyword') }}" class="selectpicker"
                        data-live-search="true" name="area">
                    @foreach(\App\Models\Area::get() as $area)
                        <option {{ request('area') == $area->id ? 'selected' : '' }} value="{{ $area->id }}">
                            {{ $area->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="fixall search-btn hvr-shutter-out-horizontal">بحث</button>
            </form>
        </div>
    </div>
    <div class="navbar-sec">
        <div class="container">
            <ul class="fixall nav-links list-unstyled">
                @foreach(\App\Models\Depts::where('parent_id' , null)->get() as $dept)
                    <li class="fixall navlink-li mega-menu-btn"><a href="#!" class="fixall navlink">{{ $dept->name }}</a>
                        @if($dept->childs()->count())
                            <div class="megamenu-cont ">
                                @php $i = 1 @endphp
                                @foreach($dept->childs as $child)
                                    @if($i % 6 == 1)
                                        <ul class="links">
                                        @endif



                                        <!--@if($child->childs()->count())-->
                                            <!--<li class="fixall navlink-li lawcat ">-->
                                        <!--    <a class="fixall navlink moaccordion" href="#!">{{ $child->name }}</a>-->
                                            <!--    <ul class="with_childs mopanel">-->
                                        <!--        @foreach($child->childs as $child)-->
                                        <!--        <li class="fixall navlink-li"><a href="{{ $child->full_link }}"-->
                                        <!--                class="fixall navlink">{{ $child->name }}</a></li>-->
                                            <!--        @endforeach-->
                                            <!--    </ul>-->
                                            <!--</li>-->
                                            <!--@else-->
                                        <!--<li class="fixall navlink-li"><a href="{{ $child->full_link }}"-->
                                        <!--        class="fixall navlink">{{ $child->name }}</a></li>-->
                                            <!--@endif-->
                                            @if($i % 6 == 0)
                                        </ul>
                                    @endif
                                    @php $i++ @endphp
                                @endforeach
                            </div>
                        @endif
                    </li>
                @endforeach
                <?php $i = 1; ?>


            </ul>
        </div>
        </li>
        </ul>
    </div>
</div>
</div>
<!-- End Header -->

<!-- Start Side-bar -->
<div class="xs-nav nav">
    <div class="main-xs-nav">
        <!-- <i class="fas fa-times closebtn"></i> -->
        <ul class="fixall nav-links list-unstyled">

            @php $ii=2; @endphp
            @foreach(\App\Models\Depts::where('parent_id' , null)->get() as $dept)
                {!! drawMenu($dept,$ii) !!}
                <?php $ii++; ?>
            @endforeach

        </ul>
        <a href="{{ route('advertise.create') }}" class="fixall add-ad hvr-shutter-out-horizontal"><i
                class="fas fa-tag"></i>اضف اعلانك</a>
            @if(Auth::check())
                &nbsp; &nbsp;
                @if(isset(auth()->user()->Expire_Date) )
                    @php
                        $now = strtotime(date('d-m-Y')); // or your date as well
                        $your_date = strtotime(auth()->user()->Expire_Date);
                        $datediff =  $your_date - $now;
                        $days =  round($datediff / (60 * 60 * 24));
                        if($days > 0){
                        echo'
                            <a class="fixall" style="color:#580707;display: flex;justify-content: center;" href="'.url("members").'">
                             بقي '.$days.' يوم  لأشتراكك
                             </a>
                        ';

                        }else{
                             echo'
                              <a class="fixall" style="color:#580707;display: flex;justify-content: center;" href="'.url("members").'">
                             اشتراك
                             </a>
                        ';
                        }
                    @endphp
                @else
                    <a class="fixall" style="color:#580707;display: flex;justify-content: center;" href="{{url("members")}}">
                        اشتراك
                    </a>
                @endif
        @endif
                 <!--<div class="user-nav">-->
                                <!--<div class="right-nav">-->
 @if(!Auth::check())
   <p style="text-align:center ;  text-size:20px">
       <a href="{{ route('login') }}" style="margin-left:10px;color:#6d1c1c !important " class="fixall log"> دخــــــــول </a>
    </p>
       <hr>
  <p style="text-align:center ; text-size:20px">
        <a href="{{ route('signup') }}" style="color:#6d1c1c !important" class="fixall log">تسجيل </a>
 </p>
@endif                                <!--</div>-->

    </div>
</div>
<!-- End Side Bar -->


