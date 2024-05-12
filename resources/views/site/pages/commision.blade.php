@extends('site.index')
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/commision.css")}}">
@endpush
@section('title') حساب عمولة الموقع @stop
@section('page')
<div id="content" class="col-md-12 nopadding">
    <div id="box-contents">
        <div class="comm">
            <div class="container">
                <!-- Start Clac -->
                <div class="calc-sec">
                    <div class="container">
                        <div class="calc">
                            <h1 class="fixall calc-title">حاسبة العمولة من البائع بنسبة %{{ $info->commision_seller }}</h1>
                            @if(\Auth::user())
                                @if(Session::has('true'))
                                <div class="alert alert-success">  {{ Session::get('true') }}  </div>
                                @endif
                                @if(Session::has('error'))
                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                @endif
                                <form novalidate class="price-calc" method="post" action="{{ route('commision.store') }}">
                                    <div class="first_line">
                                        <div class="enter-price-cont">
                                            <div class="money">
                                                <input type="number" class="enter-ptice" name="adv_price" value="{{ old('adv_price') }}" class="fixall" placeholder="ادخل المبلغ">
                                            </div>
                                        </div>
                                        <div class="arrow"> <i class="fas fa-long-arrow-alt-left"></i></div>
                                        <div class="out-price-cont">
                                            <div class="money">
                                                <input type="number" class="out-price" class="fixall" placeholder=" المبلغ المستحق على البائع"
                                                    disabled>
                                                <input type="hidden" name="price" class="out-price2" class="fixall" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="second_line">
                                        <div class="enter-price-cont">
                                            <input value="{{ old('adv_id') }}" type="number" name="adv_id" class="fixall" placeholder="رقم الإعلان ( إختياري )">
                                        </div>
                                        <div class="out-price-cont">
                                            <input type="submit" class="fixall" value="الدفع بواسطه البوابة الإلكترونيه">
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            @else
                                <form novalidate class="price-calc">
                                    <div class="enter-price-cont">
                                        <div class="money">
                                            <input type="number" class="enter-ptice" class="fixall" placeholder="ادخل المبلغ">
                                        </div>
                                    </div>
                                    <div class="arrow"> <i class="fas fa-long-arrow-alt-left"></i></div>
                                    <div class="out-price-cont">
                                        <div class="money">
                                            <input type="number" class="out-price" class="fixall" placeholder=" المبلغ المستحق على البائع"
                                                disabled>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Clac -->
                <div class="ways">
                    <div class="ways-head">
                        <h2>طرق الدفع</h2>
                        <?php /* <span>يمكنك تحويل المبلغ عن طريق الحوالة البنكية</span> */ ?>
                    </div>
                    <div class="ways-info">
                        @forelse($banks as $b)
                        <div class="way-info">
                            <img src="{{$b->image}}" alt="">
                            <p>{{ $b->name }}</p><span>{{$b->info}}</span>
                        </div>
                        @empty
                        <div class="way-info">
                            لا توجد طرق للدفع الأن
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="green-box">
                    <a href="{{route('transfer')}}">
                        <p>إذا قمت بأي تحويل من فضلك قم بتأكيد التحويل من هنا</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
    $(document).ready(function () {
        $("#numElt").on("keyup", function () {
            var num_val = $(this).val();
            var percent = (num_val * <?php echo floatval($info->commision_seller) ?>) / 100;
            $('#ruElt').val(percent);
        });

        $("#numElt_buyer").on("keyup", function () {
            var num_val = $(this).val();
            var percent = (num_val * <?php echo floatval($info->commision_buyer) ?>) / 100;
            $('#ruElt_buyer').val(percent);
        });
    });
</script>
@endpush