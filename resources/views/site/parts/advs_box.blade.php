@if($ad->getdept)
<div class="{{ isset($dept) && !request('first') ? '' : 'col-md-4' }} col-sm-6 col-xs-12 post-view">
    <div class="post-cont">
        <a href="{{ $ad->link }}" class="post-img-a">
            <!--<div class="post-img">-->
            <div class="post-img-a">

                @if($ad->user->online == 0)
                    <!--<span style=" background: unset;color:red ;     margin-bottom: 70px !important;" class="img-abs adds-stat deactive">غير متصل</span>-->
                @else
                    <!--<span style=" background: unset;    margin-bottom: 70px !important;" class="img-abs adds-stat  active">متصل</span>-->
                @endif
                <!--<span style=" background: unset;color:black" class="img-abs adds-views">{{ $ad->views }} مشاهده</span>-->
                <div class="img-tr" style="background-image: url('{{ $ad->image }}')"></div>
            </div>
        </a>
        <div class="post-info">
            <div class="price">
                @if($ad->price)
                {{ $ad->price }} ريال
                @elseif( $ad-> show_phone != "")
                      
                         <a href="tel:{{ $ad->user->phone }}">اتصل بالمعلن</a>
                @else
                  <a href="#" disable  placeholder="رقم الجوال غير متوفر"> 
                  اتصل بالمعلن</a>
                @endif 
                
             
            </div>
               @if($ad->complete == 1)
                 <div style="position: absolute; top: 29%; left: 33%; padding: 15px; border: 3px solid #fff; color: #fff; font-size: 36px; background: #0000005c;" ><a  style="color:#fff"  placeholder="لقد تم البيع"> 
                   تم البيع</a>
                   </div>
                @endif
                
            <span class="ad_date"><i class="fa fa-clock"></i> {{ date('Y-m-d' , strtotime($ad->created_at)) }}</span>
            <div class="img-info">
                <a href="{{ $ad->link }}" class="fixall title" style="white-space: nowrap;">{{ $ad->title }}</a>
                {{-- <a href="{{ $ad->getdept->link }}" class="fixall cat">{{ $ad->getdept->name }}</a> --}}
            </div>
            <p class="desc fixall">{{ $ad->short }}
            </p>
            <div class="info">
                @if(is_array($ad->main_options))
                @foreach($ad->main_options as $icon => $val)
                <p cla ss="fixall"><i class="fa {{$icon}}"></i> {{ $val }}</p>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    {{-- </a> --}}
</div>
@endif


<!--@if($ad->getdept)-->
<!--<div class="{{ isset($dept) && !request('first') ? '' : 'col-md-4' }} col-sm-6 col-xs-12 post-view">-->
<!--    <div class="post-cont">-->
<!--        <a href="{{ $ad->link }}" class="post-img-a">-->
<!--            <div class="post-img">-->
<!--                @if($ad->user->online == 0)-->
<!--                    <span style=" background: unset;color:red" class="img-abs adds-stat deactive">غير متصل</span>-->
<!--                @else-->
<!--                    <span style=" background: unset;" class="img-abs adds-stat  active">متصل</span>-->
<!--                @endif-->
<!--                <span style=" background: unset;color:white" class="img-abs adds-views">{{ $ad->views }} مشاهده</span>-->
<!--                <div class="img-tr" style="background-image: url('{{ $ad->image }}')"></div>-->
<!--            </div>-->
<!--        </a>-->
<!--        <div class="post-info">-->
<!--            <div class="price">-->
<!--                @if($ad->price)-->
<!--                {{ $ad->price }} ريال-->
<!--                @else-->
<!--                <a href="tel:{{ $ad->user->phone }}">اتصل بالمعلن</a>-->
<!--                @endif-->
<!--            </div>-->
<!--            <span class="ad_date"><i class="fa fa-clock"></i> {{ date('Y-m-d' , strtotime($ad->created_at)) }}</span>-->
<!--            <div class="img-info">-->
<!--                <a href="{{ $ad->link }}" class="fixall title" style="white-space: nowrap;">{{ $ad->title }}</a>-->
<!--                {{-- <a href="{{ $ad->getdept->link }}" class="fixall cat">{{ $ad->getdept->name }}</a> --}}-->
<!--            </div>-->
<!--            <p class="desc fixall">{{ $ad->short }}-->
<!--            </p>-->
<!--            <div class="info">-->
<!--                @if(is_array($ad->main_options))-->
<!--                @foreach($ad->main_options as $icon => $val)-->
<!--                <p cla ss="fixall"><i class="fa {{$icon}}"></i> {{ $val }}</p>-->
<!--                @endforeach-->
<!--                @endif-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    {{-- </a> --}}-->
<!--</div>-->
<!--@endif-->