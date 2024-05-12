@extends('site.index')
@section('title' , $title)
@section('styles')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop
@section('page')
<!-- Start Result Page -->
<div class="result-page">
    <div class="container">
        <div class="result-title">
            <h1 class="result-head fixall"><span>({{ $advs_count }}) إعلان</span> : {{ $current_dept->name ?? $title }}
            </h1>
            <div class="filters-xs">

                <div class="filters-btn"></div>
                <div class="result-sort">
                    <div class="chooseBtns-grid">
                        <i class="fas fa-th grid view-active"></i></button>
                        <i class="fas fa-th-list list"></i></button>
                        <i class="fas fa-list linear"></i>
                    </div>
                    <h2 class="fixall">حسب المدينة </h2>
                    <select name="area_id" class="selectpicker" onchange="window.location=this.value">
                        <option hidden>اختر المدينة</option>
                        @foreach(\App\Models\Area::all() as $area)
                                <option {{ request('area') == $area->id ? 'selected' : '' }}
                                    value="{{ $current_dept->id ? $current_dept->full_link : route('search' , array_merge(request()->query() , ['order_type' => $area->id])) }}">
                                {{ $area->name }}</option>
                        @endforeach
                    </select>
                    <h2 class="fixall">رتب حسب</h2>
                    <select class="selectpicker" title="الأكثر تطابقاً" onchange="window.location=this.value">
                        @foreach(search_types() as $key => $type)
                        <option {{ request('order_type') == $key ? 'selected' : '' }}
                            value="{{ $current_dept->id ? $current_dept->full_link : route('search' , array_merge(request()->query() , ['order_type' => $key])) }}">
                            {{ $type }}</option>
                        @endforeach
                    </select>
                    &nbsp;&nbsp;
                    <h2 class="fixall">عدد الإعلانات </h2>
                    <select name="perpage" class="selectpicker" onchange="window.location=this.value">
                        <option {{ request('perpage') == 20 ? 'selected' : '' }}
                            value="{{ $current_dept->id ? $current_dept->full_link : route('search' , array_merge(request()->query() , ['order_type' => $key , 'perpage' => 20])) }}">20</option>
                        <option {{ request('perpage') == 50 ? 'selected' : '' }}
                            value="{{ $current_dept->id ? $current_dept->full_link : route('search' , array_merge(request()->query() , ['order_type' => $key , 'perpage' => 50])) }}">50</option>
                        <option {{ request('perpage') == 100 ? 'selected' : '' }}
                            value="{{ $current_dept->id ? $current_dept->full_link : route('search' , array_merge(request()->query() , ['order_type' => $key , 'perpage' => 100])) }}">100</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="result-cont">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <div class="filters-cont">
                        <form novalidate class="add_item_form">
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
                                                value="{{ $area->id }}">{{ $area->name }}</option>
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
                                        <a href="{{ $dept->full_link }}"
                                            class="fixall cat-filter {{ $dept->id == $current_dept->id ? 'active' : '' }}">{{ $dept->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            @if(isset($current_dept) && isset($child_dept))
                            <div class="marks-cont cats-cont filter-cont">
                                <h3 class="fixall filter-header">الأقسام الفرعية</h3>
                                <ul class="fixall list-unstyled cats-filter seemore-menu marks-filter ScrollMe" style="overflow-y: auto;">
                                    <li class="fixall mark-li"><a href="{{ $current_dept->super_parent->full_link }}"
                                            class="fixall mark-filter">جميع
                                            إعلانات {{ $current_dept->super_parent->name }}</a><span
                                            class="count">{{ $current_dept->super_parent->advs_n->count() }}</span>
                                    </li>
                                    @foreach($current_dept->super_parent->childs as $child)
                                    <li class="fixall mark-li">
                                        <a href="{{ $child->full_link }}"
                                            class="fixall mark-filter {{ $child_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a>
                                        <span class="count">{{ $child->advs_n->count() }}</span>
                                    </li>
                                    @if(in_array($child->id , $child_dept->parents) || $child_dept->id == $child->id)
                                    @foreach($child->childs as $child)
                                    <li style="padding-right:20;" class="fixall mark-li">
                                        <a href="{{ $child->full_link }}"
                                            class="fixall mark-filter {{ $child_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a>
                                        <span class="count">{{ $child->advs_n->count() }}</span>
                                    </li>
                                    @if(in_array($child->id , $child_dept->parents) || $child_dept->id == $child->id)
                                    @foreach($child->childs as $child)
                                    <li style="padding-right:40;" class="fixall mark-li">
                                        <a href="{{ $child->full_link }}"
                                            class="fixall mark-filter {{ $child_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a>
                                        <span class="count">{{ $child->advs_n->count() }}</span>
                                    </li>
                                    @if(in_array($child->id , $child_dept->parents) || $child_dept->id == $child->id)
                                    @foreach($child->childs as $child)
                                    <li style="padding-right:40;" class="fixall mark-li">
                                        <a href="{{ $child->full_link }}"
                                            class="fixall mark-filter {{ $child_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a>
                                        <span class="count">{{ $child->advs_n->count() }}</span>
                                    </li>
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif

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
                                            <a href="{{ request()->url().'?'.http_build_query(array_merge([$current_dept->id , $current_dept->name], request()->query() , ['date' => 'week'])) }}"
                                                class="fixall cat-filter {{ request('date') == 'week' ? 'active' : '' }}">منذ
                                                أسبوع</a>
                                        </li>
                                        <li class="fixall cat-li">
                                            <a href="{{ request()->url().'?'.http_build_query(array_merge([$current_dept->id , $current_dept->name], request()->query() , ['date' => 'month'])) }}"
                                                class="fixall cat-filter {{ request('date') == 'month' ? 'active' : '' }}">منذ
                                                شهر</a>
                                        </li>
                                        <li class="fixall cat-li">
                                            <a href="{{ request()->url().'?'.http_build_query(array_merge([$current_dept->id , $current_dept->name], request()->query() , ['date' => 'year'])) }}"
                                                class="fixall cat-filter {{ request('date') == 'year' ? 'active' : '' }}">منذ
                                                سنة</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="row">
                        @foreach($advs as $ad)
                        @include('site.parts.advs_box')
                        @endforeach
                        @if(!count($advs))
                        <div class="no_results">
                            عفواً لا يوجد إعلانات متوفرة لهذة الصفحة
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        {{ $advs->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- End Result Page -->
@stop

@section('scripts')
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>
<script>
    $("[type='date']").datetimepicker();
</script>
@endsection
