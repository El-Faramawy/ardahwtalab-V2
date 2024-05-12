@push('meta')
<meta property="og:title" content="{{ $info->title }}">
<meta property="og:description" content="{{ strip_tags($info->description) }}">
<meta property="og:image" content="{{ $info->image ?? '' }}">
<meta property="og:url" content="{{ $info->link }}">
<meta name="twitter:title" content="{{ $info->title }}">
<meta name="twitter:description" content="{{ strip_tags($info->description) }}">
<meta name="twitter:image" content="{{ $info->image ?? '' }}">
<meta name="twitter:card" content="summary">
<meta property="og:image:alt" content="{{ $info->title }}" />
<meta name="description" content="{{ strip_tags($info->description) }}" />
@endpush
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRskeu4X1413OUuN6rHmOxr2nbjbx267k&sensor">
</script>
<!-- Start Breadcrumb -->
<div class="breadcrumb-sec">
    <div class="container">
        <ol class="breadcrumb fixall">
            <li><a href="{{ url('/') }}" class="fixall">الرئيسية</a></li>
            {!! $info->tree !!}
        </ol>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Post Page -->
<div class="post-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="titles">
                    <div class="title">
                        <h1 class="fixall post-header">{{ $info->title }} <span
                                style="color:#6d1c1c">( رقم الاعلان  #{{$info->id}})</span></h1>
                        @if($info->price)
                        <h1 class="fixall post-price">{{ $info->price }} ريال</h1>
                        @endif
                    </div>
                    <h3 class="fixall post-place">{{ $info->address }}</h3>
                </div>
                <div class="page-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#photos" class="photos-link"><i
                                    class="fas fa-images"></i><span>صور</span></a></li>
                        <li><a data-toggle="tab" href="#mapcont" class="map-link"><i
                                    class="fas fa-map-marker-alt"></i><span>الموقع علي
                                    الخريطة</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="photos" class="tab-pane fade in active">
                            <div class="slider">
                                <div id="main-slider" class="owl-carousel main-slider">
                                    @foreach($info->images as $image)
                                    <div class="item"><a href="#!"><img src="{{ asset($image->image) }}"
                                                class="img-responsive"></a></div>
                                    @endforeach
                                    @if(!$info->images()->count())
                                    <div class="item"><a href="#!"><img src="{{ url('item_placeholder.png') }}"
                                                class="img-responsive"></a></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="mapcont" class="tab-pane fade">
                            <div id="mappy" style="width: 100%; height: 100%;" long="{{ $info->lng }}"
                                lat="{{ $info->lat }}" address="{{ $info->address }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="owner-info">
                    <div class="owner">
                        <div class="owner-photo"><img src="{{url($info->user->image)}}" alt=""></div>
                        <div class="owner-featue">
                            <a href="{{ route('users.show' , $info->user->id) }}"
                                class="fixall owner-name">
                                @if(!is_null($info->user->documentation))
                                    @if($info->user->documentation->activeted == 1)
                                        <i class="fa fa-star" style="color:green;"></i>
                                    @endif
                                @endif
                                {{ $info->user->username }}
                                </a>
                            <p class="fixall post-date">{{ $info->created_at_ar }}</p>
                        </div>
                        <div class="owner-featue" style="position: absolute;left: 24px;">
                            <?php
                                $rates = GetUserRate($info->user);
                            ?>
                            @for($i = 0; $i < $rates; $i++)
                                <i class="fa fa-star" style="color:#abab00;"></i>
                            @endfor
                            @for($i = 5; $i > $rates;$i--)
                                <i class="fa fa-star" style="color:black;"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="show-btns">
                        @if(auth()->check() && auth()->user()->id == $info->user_id)
                        <a href="{{ route('advertise.republished' , $info->id) }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal">
                            <i class="fas fa-puzzle-piece"></i>
                            إعاده النشر
                        </a>

                        <a href="{{ route('advertise.edit' , $info->id) }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal"><i
                                class="fas fa-edit"></i>تعديل الإعلان</a>
                        <a href="{{ route('advertise.remove' , $info->id) }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal remove_item"><i
                                class="fas fa-trash"></i>حذف الإعلان</a>
                        @if($info->complete != 1)
                        <a href="{{ route('advertise.complete' , $info->id) }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal complete_item"><i
                                class="fas fa-remove"></i> إضغط هنا إذا تم البيع</a>
                         @endif()
                        <a href="#"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal "><i
                                class="fas fa-clock"></i>تاريخ انتهاء الإعلان:
                                @if(auth()->user()->Expire_Date == null)
                                        @php

                                        $now = new DateTime(); //now

                                        $hours = 24; // hours amount (integer) you want to add
                                        $modified = (clone $now)->add(new DateInterval("PT{$hours}H")); // use clone to avoid modification of $now object
                                        echo "\n". $modified->format('Y-m-d '); // 2021-09-12 13:01:55

                                        @endphp

                                    @else
                                    {{ $info->end_date }}
                                @endif
                                </a>
                        @endif
                        @if($info->show_phone)
                        <a href="tel:{{ $info->user->phone }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal"><i
                                class="fas fa-mobile-alt"></i>اتصل بالمعلن</a>
                        @endif
                        <a target="_blank" href="{{ route('advertise.print' , $info->id) }}"
                            class="fixall show-btn owner-num hvr-shutter-out-horizontal"><i
                                class="fas fa-print"></i>طباعة الإعلان</a>
                        @if(!(auth()->check() && auth()->user()->id == $info->user_id))
                        <a href="{{ route('users.chat',$info->user->id)  }}"
                            class="fixall show-btn text-owner hvr-shutter-out-horizontal"><i
                                class="far fa-envelope"></i>مراسلة صاحب
                            الإعلان</a>
                        @endif
                    </div>
                    <div class="user-btns" style="margin-bottom: 10px;">
                        <a class="fixall user-btn add-wish hvr-shutter-out-horizontal"
                            href="#!">
                            <i class="fas fa-certificate" style="color: {{ ($info->user->online == 0) ? 'red': 'green' }}"></i>
                            {{ ($info->user->online == 0) ? 'غير متصل': 'متصل' }}
                        </a>
                        <a class="fixall user-btn add-wish hvr-shutter-out-horizontal"
                            href="#!">
                            <i class="fas fa-eye"></i>
                            {{ $info->views }}
                        </a>
                    </div>
                    <div class="user-btns">
                        <a class="fixall user-btn add-wish hvr-shutter-out-horizontal {{ islike($info->id) ? 'active' : '' }}"
                            href="{{ route('like',$info->id) }}"><i
                                class="fas fa-heart"></i>{{ islike($info->id) ? 'حذف من المفضلة' : 'أضف للمفضلة' }}</a>
                        <a class="fixall user-btn add-report hvr-shutter-out-horizontal">الإبلاغ عن
                            مخالفة</a>
                    </div>
                    <div class="report-form">
                        <form novalidate class="report" method="post"
                            action="{{ route('advertise.claims' , $info->slug) }}">
                            {{ csrf_field() }}
                            <div class="radios">
                                <label class="radio-cont">
                                    <input type="radio" checked="checked" name="text"
                                        value="هذا الإعلان غير قانوني/ احتيالي">
                                    <span class="checkmark"></span>
                                    هذا الإعلان غير قانوني/ احتيالي
                                </label>
                                <label class="radio-cont">
                                    <input type="radio" name="text" value="هذا الإعلان غير مرغوب فيه">
                                    <span class="checkmark"></span>
                                    هذا الإعلان غير مرغوب فيه
                                </label>
                                <label class="radio-cont">
                                    <input type="radio" name="text" value="هذا الإعلان مكرر">
                                    <span class="checkmark"></span>
                                    هذا الإعلان مكرر
                                </label>
                                <label class="radio-cont">
                                    <input type="radio" name="text" value="هذا الإعلان في الفئة الخاطئة">
                                    <span class="checkmark"></span>
                                    هذا الإعلان في الفئة الخاطئة
                                </label>
                                <label class="radio-cont">
                                    <input type="radio" name="text" value="الإعلان ضد قواعد النشر">
                                    <span class="checkmark"></span>
                                    الإعلان ضد قواعد النشر
                                </label>
                            </div>
                            <div class="text-area">
                                <textarea class="fixall more-info"></textarea>
                            </div>
                            <div class="form-btns">
                                <button type="submit"
                                    class="fixall form-btn send hvr-shutter-out-horizontal">إرسال</button>
                                <button type="reset"
                                    class="fixall form-btn cls hvr-shutter-out-horizontal">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
                @include('site.advs.share')
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">



                <div class="post-features">
                    <div class="row">
                        @foreach($info->titles as $title => $options)
                        <div class="col-md-6">
                            <div class="post-featue">
                                <h1 class="table-title fixall">{{ $title }}</h1>
                                <div class="table-cont">
                                    <table>
                                        <tbody>
                                            @foreach($options as $name => $val)
                                            <tr>
                                                <td class="table-item">{{ $name }}</td>
                                                <td class="table-item-featue">{{$val }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if($info->description && $info->description != '')
                <div class="desc">
                    <h1 class="des-head fixall">المواصفات</h1>
                    <p class="desc-txt fixall" style="word-break: break-word;">{!! $info->description !!}</p>
                </div>
                @endif




                @if($info->getdept->super_parent->home)
                <div class="bidding-cont">
                    <h1 class="fixall post-header" style="color:#6d1c1c">المزايدات</h1>
                    <form class="fixall bidding" method="post" action="{{ route('bids') }}" novalidate>
                        {{ csrf_field() }}
                        @if(auth()->check() && !$info->bids()->where('user_id' , auth()->user()->id)->exists() &&
                        auth()->user()->id != $info->user->id)
                        <div class="form-row">
                            <input type="hidden" name="advs_id" value="{{ $info->id }}">
                            <div class="price-cont"> <label class="fixall price-lable">السعر</label>
                                <input required name="price" class="fixall price-input" type="number"
                                    placeholder="سعر المزايدة"></div>
                            <button type="submit" class="send fixall hvr-shutter-out-horizontal">إرسال</button>

                        </div>
                        @endif
                        <?php $i = 1; ?>
                        @if($info->bids()->count())
                        <div class="all-prev">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="prev head">
                                        #
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="prev head">
                                        <p class="fixall col">الاسم</p>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="prev head">
                                        <p class="fixall col">السعر</p>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="prev head">
                                        <p class="fixall col">التاريخ</p>
                                    </div>
                                </div>
                            </div>
                            @foreach($info->bids as $bid)
                            @if($bid->user)
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="prev">
                                        <p class="fixall col">{{ $i++ }}</p>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="prev">
                                        <p class="fixall col">
                                            <a
                                                href="{{ route('users.show' , $bid->user->id) }}">{{ $bid->user->username }}</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="prev">
                                        <p class="fixall col">{{ $bid->price }}</p>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="prev">
                                        <p class="fixall col">{{ $bid->created_at }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <hr>

{{--    <div class="similar">--}}
{{--        <div class="container">--}}
{{--            <h1 class="fixall similar-head">إعلانات مشابهة</h1>--}}
{{--            <div class="row">--}}
{{--                @foreach($info->similars as $ad)--}}
{{--                @include('site.parts.advs_box')--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>

{{--  <div class="row">--}}
{{--     <div class="col-md-8">--}}
{{--                                    @foreach($info->images as $image)--}}
{{--                                    <div ><a href="#!"><img style="width:100%;height:100%" src="{{ asset($image->image) }}"--}}
{{--                                                class="img-responsive"></a></div>--}}
{{--                                                <hr>--}}
{{--                                    @endforeach--}}
{{--                                    @if(!$info->images()->count())--}}
{{--                                    <div ><a href="#!"><img style="width:100%;height:500px" src="{{ url('item_placeholder.png') }}"--}}
{{--                                                class="img-responsive"></a></div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--  </div>--}}

@push('scripts')
<script>
    $('.remove_item').click(function () {
        var btn = $(this);
        swal({
            type: "warning",
            title: "هل أنت متأكد ؟",
            text: "هل تريد حذف الإعلان بالفعل",
            confirmButtonText: "موافق",
            showCancelButton: true,
            cancelButtonText: "إلغاء",
        }).then(function (ok) {
            if (ok.value == true) {
                window.location = btn.attr('href');
            }
        });
        return false;
    });

    $('.complete_item').click(function () {
        var btn = $(this);
        swal({
            type: "warning",
            title: "هل أنت متأكد ؟",
            text: "في حال تأكيد البيع لا يمكن التراجع ",
            confirmButtonText: "موافق",
            showCancelButton: true,
            cancelButtonText: "إلغاء",
        }).then(function (ok) {
            if (ok.value == true) {
                window.location = btn.attr('href');
            }
        });
        return false;
    });
</script>
@endpush

<!-- End Post Page -->
