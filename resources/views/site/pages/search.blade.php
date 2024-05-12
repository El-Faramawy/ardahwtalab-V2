@extends('site.index')
@section('title' , "البحث المتقدم")
@section('page')
<!-- End Adv Search -->
<div class="adv-search-cont">
    <div class="container">
        <div class="adv-search">
            <h1 class="adv-search-header fixall">ابحث عن {{ $child_dept->name }}</h1>
            <h3 class="adv-subhead fixall">نتائج البحث {{ $child_dept->all_advs->count() }} إعلانات</h3>
            <div class="adv-search-form">
                <div class="row">
                    <form novalidate action="{{ route('search') }}">
                        <div class="col-md-4" style="float-right">
                            <input name="keyword" placeholder="أدخل رقم الإعلان أو كلمة البحث">
                        </div>

                        @if($child_dept->childs()->count())
                        <div class="col-md-2 col-sm-6">
                            {{-- <label class="label-xs">الماركة</label> --}}
                            <select class="selectpicker" id="make" name="dept_id">
                                <option value="{{ $child_dept->id }}">كل ال{{ $child_dept->name }}</option>
                                @foreach($child_dept->childs as $dept)
                                <option {{ $child_dept->id == $dept->id ? 'selected' : '' }} value="{{ $dept->id }}">
                                    {{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-2 col-sm-6">
                            {{-- <label class="label-xs">الماركة</label> --}}
                            <select class="selectpicker" id="make" name="area" title="المدينة">
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <input class="datee" name="from_date" placeholder="التاريخ : من">
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <input class="datee" name="to_date" placeholder="التاريخ : إلى">
                        </div>
                        <div class="col-md-6">
                            <div class="adv-search-btn-cont">
                                <button class="fixall hvr-shutter-out-horizontal adv-search-btn">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="row result-cont">
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
<!-- Start Cats Nav -->
@stop