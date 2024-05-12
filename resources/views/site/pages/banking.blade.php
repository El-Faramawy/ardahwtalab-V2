@extends('site.index')
@section('title') طرق الدفع @stop
@push('styles')
<link rel="stylesheet" href="{{asset("thamen/css/commision.css")}}">
<style>
    .categories-section {
        padding: 0;
    }
    
</style>
@endpush
@section('page')
<div id="content" class="col-md-12 nopadding"> 
    <div id="box-contents">
        <h1 class="pagetitle">
            طرق الدفع 
        </h1>
        <div class="box-contents-content"> 
            <div class="ways" style="border: 0;">
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
            <div class="clear"></div>
            <div class="green-box">
                    <a href="{{route('transfer')}}"><p>إذا قمت بأي تحويل من فضلك قم بتأكيد التحويل من هنا</p></a>
            </div>
        </div>
    </div>
</div>
@stop