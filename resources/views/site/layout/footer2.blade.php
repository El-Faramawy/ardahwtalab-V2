<?php $commision = \App\Models\Advs_config::first()->commision_seller ?? 1 ?>
<!-- Start Cats Nav -->
<div class="cats">
    <div class="container">
        <div class="cat-nav">
            @foreach(\App\Models\Depts::where('parent_id' , null)->get() as $dept)
            <div class="cat-nav-links">
                <h3 class="cat-nav-links-header fixall">{{ $dept->name }}</h3>
                <ul class="list-unstyled cat-links fixall">
                    @foreach($dept->childs as $child)
                    <li class="cat-nav-li fixall"><a href="{{ $child->link }}"
                            class="cat-link hvr-backward fixall">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- End Cats Nav -->

<!-- Start Banner -->
<div class="banner-sec">
    <div class="container">
        <div class="banner">
            <div class="row">
                <div class="col-sm-6 hidden-xs">
                    <img src="{{ url('site') }}/images/banner-phone.png" class="img-responsive banner-img">
                </div>
                <div class="col-sm-6">
                    <div class="banner-info">
                        {{-- <h1 class="fixall banner-title">بِعْ واشتري في لحظة</h1> --}}
                        <h1 class="fixall banner-subtitle">حمل تطبيق عرض وطلب الآن</h1>
                        <div class="download">
                            <a href="{{ getSiteConfig('ios') ?? '#' }}"><img
                                    src="{{ url('site') }}/images/banner-app.png" class="img-responsive"></a>
                            <a href="{{ getSiteConfig('android') ?? '#' }}"><img
                                    src="{{ url('site') }}/images/banner-play.png" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
                <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                    <img src="{{url('site')}}/images/banner-phone.png" class="img-responsive banner-img">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Banner -->
<!-- Start Clac -->
<div class="calc-sec">
    <div class="container">
        <div class="calc">
            <h1 class="fixall calc-title">حاسبة العمولة من البائع بنسبة %{{ $commision }}</h1>
            <form novalidate class="price-calc">
                <div class="enter-price-cont">
                    {{-- <label for="enter-price" class="enter-price fixall">إذا تم بيع السلعة بسعر</label> --}}
                    <div class="money">
                        <input type="number" class="enter-ptice" class="fixall" placeholder="ادخل المبلغ">
                        {{-- <span class="cur">ريال سعودي</span> --}}
                    </div>
                </div>
                <div class="arrow"> <i class="fas fa-long-arrow-alt-left"></i></div>
                <div class="out-price-cont">
                    {{-- <label for="out-price" class="out-price fixall">فإن العمولة تكون</label> --}}
                    <div class="money">
                        <input type="number" class="out-price" class="fixall" placeholder=" المبلغ المستحق على البائع"
                            disabled>
                        {{-- <span class="cur">ريال سعودي</span> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Clac -->
<!-- Start Footer -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 right-foot">
                <a href="{{ url('/') }}" class="logo"><img src="{{ layout_data()->config->logo }}"
                        class="img-responsive"></a>
                <p class="site_description">{{ layout_data()->config->description }}</p>

            </div>
            <div class="col-md-4 col-sm-6">
                <div class="foot-nav-links">
                    <h3 class="foot-nav-links-header linkheading fixall">معلومات</h3>
                    <ul class="list-unstyled foot-links fixall">
                        @foreach(\App\Models\Pages::where('footer' , 1)->get() as $page)
                        <li class="foot-nav-li fixall"><a href="{{ $page->url }}"
                                class="foot-link hvr-backward fixall">{{ $page->title }}</a></li>
                        @endforeach
                        <li class="foot-nav-li fixall"><a href="{{ route('commision') }}"
                                class="foot-link hvr-backward fixall">
                                سداد عمولة الموقع
                                </a>
                        </li>
                        <li class="foot-nav-li fixall"><a href="{{ route('contactus') }}"
                                class="foot-link hvr-backward fixall">تواصل معنا</a>
                        </li>
                        <li class="foot-nav-li fixall"><a href="{{ route('users.documentation_form') }}"
                                class="foot-link hvr-backward fixall">توثيق العضوية</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <h3 class="follow-header linkheading fixall">تابعنا على</h3>
                <div class="social">
                    @foreach(site_socials() as $s)
                    <a class="fixall social-link {{contactIcons()[$s->type]}}" target="_blank"
                        href="{{ get_contact_url($s) }}">

                    </a>
                    @endforeach
                </div>
                <div class="copyright">
                    <div class="supply">جميع الحقوق محفوظة © عرض وطلب
                    {{ date('Y') }}</div>
                    <div class="tasawk"><a href="//tasawk.com.sa"><img
                                src="{{ url('site') }}/images/tasawk.png" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Footer -->

<!-- Modal -->
<div id="showModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>

    </div>
</div>

<script src="{{ url('site') }}/js/bootstrap.min.js"></script>
<script src="{{ url('site') }}/js/bootstrap-select.min.js"></script>
<script src="{{ url('site') }}/js/aos.js"></script>
<script src="{{ url('site') }}/js/owl.carousel.min.js"></script>
<script src="{{ url('assets/harag') }}/js/helper.js"></script>
<script src="{{ url('assets/harag') }}/js/script.js?ver=1.0"></script>
<script src="{{ url('site') }}/js/main.js?ver=1.5"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>
<script>
    $('.lazy').Lazy();
    $('.panel').click(function(){
        $('.collapse').collapse('hide');
        $(this).find('.collapse').collapse('show');
    });
    $('form:not(.add_item_form)').submit(function(e){
        $('.requiredInp').removeClass('requiredInp');
        var inputs = $(this).find("[required]");
        var val = 0;
        inputs.each(function(key){
            if($(this).val() == ''){
                val = 1;
                $(this).addClass('requiredInp');
            }else if($(this).attr('type') == 'checkbox' && inputs[key].checked == false){
                val = 1;
                $(this).parent().find('.checkmark').addClass('requiredInp');
            }
        });
        if(val == 1){
            window.scrollTo({
                top: $('.requiredInp:visible:first').offset().top - 10,
                behavior: 'smooth',
            });
            $('.selectpicker').selectpicker('refresh');
            // window.scrollTo(0 , $('.requiredInp:visible:first').offset().top - 10);
            return false;
        }
    });
    $('body').on('keyup' , ".requiredInp" , function(){
        $(this).removeClass('requiredInp');
    });
    $('body').on('change' , ".requiredInp" , function(){
        $(this).removeClass('requiredInp');
    });
    $('.show_lawsuit_details').click(function(){
        $.get($(this).data('href') , function(result){
            $('#showModal .modal-body').html(result);
            $('#showModal').modal('show');
        });
    });
    $(".enter-ptice").keyup(function(){
        var val = $(this).val();
        var commision = parseFloat("{{ $commision }}") / 100;
        val = round(val * commision , 2);
        $(".out-price").val(val);
        $(".out-price2").val(val);
    });
    function round(value, decimals) {
        return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
    }
    $(".datee").datetimepicker({format: 'DD/MM/YYYY'});
    $(document).ready(function () {
        if (localStorage.getItem('listtype') == 'list' && $(window).width() > 500 && $('.post-page').length < 1) {
            console.log($('.filter-cont').length);
            // if($('.filter-cont').length > 0){
            //     $('.post-view').removeClass('col-sm-6');
            // }else{
                $('.post-view').removeClass('col-sm-6');
                $('.post-view').removeClass('col-md-4');
            // }
            $('.post-cont').addClass('post-list');
            $('.chooseBtns-grid i').removeClass('view-active');
            $('.list').addClass('view-active');
        }else if(localStorage.getItem('listtype') == 'grid'){
            if($('.filter-cont').length > 0){
                console.log($('.filter-cont').length);
                $('.post-view').removeClass('col-md-4');
            }
        }
        else if(localStorage.getItem('listtype') == 'linear'){
            $('.post-view').removeClass('col-sm-6').removeClass('col-md-4');
            $('.post-cont').addClass('post-linear');
            $('.chooseBtns-grid i').removeClass('view-active');
            $('.linear').addClass('view-active');
        }
        if($(window).width() <= 768){
            $('.post-list').removeClass('post-list');
            $('.post-view').removeClass('col-md-4');
            $('.post-view').addClass('col-sm-6')
        }
    });
</script>
@stack('scripts')
@include('validate')
