@extends('site.index')
@section('title') الرئيسية @stop
@section('page')

<div class="recent-ads-sec result-cont">
    <div class="container">
        <div class="div-header" style="justify-content: right !important;">
            <h1 class="fixall">اختر طريقة العرض</h1>
            <div class="sort">
                <div class="chooseBtns-grid">
                    <i class="fas fa-th grid view-active"></i>
                    <i class="fas fa-th-list list"></i>
                    <i class="fas fa-list linear"></i>
                </div>
                <h2 class="fixall">حسب المدينة </h2>
                <select name="area_id" class="selectpicker" onchange="window.location=this.value">
                    <option hidden>اختر المدينة</option>
                    @foreach(\App\Models\Area::all() as $area)
                    <option value="{{ route('search' , ['area' => $area->id]) }}">{{ $area->name }}</option>
                    @endforeach
                </select>
                &nbsp;&nbsp;
                <h2 class="fixall">عدد الإعلانات </h2>
                <select name="perpage" class="selectpicker" onchange="window.location=this.value">
                <option {{ request('perpage') == 20 ? 'selected' : '' }} value="{{ route('home' , ['perpage' => 20]) }}">20</option>
                    <option {{ request('perpage') == 50 ? 'selected' : '' }} value="{{ route('home' , ['perpage' => 50]) }}">50</option>
                    <option {{ request('perpage') == 100 ? 'selected' : '' }} value="{{ route('home' , ['perpage' => 100]) }}">100</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12 home-search">
                <div class="filters-cont">
                    <form novalidate action="{{ route('search') }}">
                        <div class="loc-cont filter-cont">
                            <div class="location">
                                <input class="fixall" value="{{ request('keyword') }}" name="keyword"
                                    placeholder="كلمة البحث" />
                                <h3 class="fixall filter-header">المكان</h3>
                                <div class="distance">
                                    <select class="selectpicker" data-live-search="true" name="area"
                                        title="اختر المنطقة">
                                        <option {{ request('area') == 'all' ? 'selected' : '' }} value="all">كل
                                            المدن</option>
                                        @foreach($areas as $area)
                                        <option {{ request('area') == $area->id ? 'selected' : '' }}
                                            value="{{ $area->id }}">
                                            {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="distance">
                                    <select class="selectpicker" name="distance" title="حدد المسافة">
                                        @for($i = 1 ; $i < 50 ; $i++) <option
                                            {{ request('distance') == $i ? 'selected' : '' }} value="{{$i}}">+
                                            {{ $i }} ميل</option>
                                            @endfor
                                    </select>
                                </div>
                                <button type="submit" class="fixall search-btn hvr-shutter-out-horizontal"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="cats-cont filter-cont">
                            <h3 class="fixall filter-header">الأقسام</h3>
                            <ul class="fixall list-unstyled cats-filter">
                                @foreach($depts as $dept)
                                <li class="fixall cat-li">
                                    <a href="{{ $dept->full_link }}" class="fixall cat-filter">{{ $dept->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="price-cont filter-cont">
                            <div class="price-form">
                                <h3 class="fixall filter-header">التاريخ</h3>
                                <div class="price-inputs-cont">
                                    <div class="min">
                                        <input value="{{ request('from_date') }}" name="from_date"
                                            class="price-input min-input fixall datee" />
                                        <span class="floating-label">من</span>
                                    </div>
                                    <div class="max">
                                        <input value="{{ request('to_date') ?? date('Y-m-d') }}" name="to_date"
                                            class="price-input max-input fixall datee" />
                                        <span class="floating-label">إلى</span>
                                    </div>
                                </div>
                                <button type="submit" class="fixall search-btn hvr-shutter-out-horizontal"><i
                                        class="fas fa-search"></i></button>
                                <ul class="fixall list-unstyled cats-filter">
                                    <li class="fixall cat-li">
                                        <a href="{{ request()->url().'?'.http_build_query(array_merge(request()->query() , ['date' => 'week'])) }}"
                                            class="fixall cat-filter {{ request('date') == 'week' ? 'active' : '' }}">
                                            أسبوع</a>
                                    </li>
                                    <li class="fixall cat-li">
                                        <a href="{{ request()->url().'?'.http_build_query(array_merge(request()->query() , ['date' => 'month'])) }}"
                                            class="fixall cat-filter {{ request('date') == 'month' ? 'active' : '' }}">
                                            شهر</a>
                                    </li>
                                    <li class="fixall cat-li">
                                        <a href="{{ request()->url().'?'.http_build_query(array_merge(request()->query() , ['date' => 'year'])) }}"
                                            class="fixall cat-filter {{ request('date') == 'year' ? 'active' : '' }}">
                                            سنة</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-md-9">
                <div class="recent-ads">
                    <div class="row">
                        @foreach($advs as $ad)
                        @include('site.parts.advs_box')
                        @endforeach
                        @if(count($advs) >= 15)
                        <div class="col-xs-12">
                            <a href="{{ route('advs.last') }}"
                                class="see-more-ads fixall hvr-shutter-out-horizontal">عرض جميع
                                الإعلانات</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Home Page -->
@stop
