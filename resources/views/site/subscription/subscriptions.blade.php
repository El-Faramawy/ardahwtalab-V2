@extends('site.index')

@section('page')
<div class="row">
        <div class="addPost-content">
    
    <p class="addPost">
        يمكنك الاشتراك باحد الباقات ادناه : 
    </p>
    </div>
    </div>
    
<div class="row" style="direction: rtl ;that-property: inherit">
    @foreach($subscriptions as $subscription)
       
            
          <div class="col-sm-6 col-md-4" height="500px">
            <div class="thumbnail">
              <div class="caption">
                <h3 >{{ $subscription->title }}</h3>
                <br/>
                <p style="text-align:right  !important;that-property: inherit">{!! $subscription->description !!}</p>
                <span> المدة الزمنية : </span>
                <span>{{ $subscription->duration / 24 }}</span>
                <span> يوم </span>
                
                <form class="price-calc" method="post" action="{{ route('commision.store') }}" id="form{{$subscription->id}}">
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                    <input type="hidden" name="subscription_id" value="{{ $subscription->id }}">
                    <input type="hidden" name="adv_id" value="{{ $adv_id }}">
                </form>
                <p class="addPost">
                     المبلغ : {{$subscription->price  }} ريال
                </p>
                <p><input type="submit" form="form{{$subscription->id}}" class="btn btn-primary" role="button" style="background-color: #6d1c1c" value="اشترك"></p>
              </div>
            </div>
      </div>
     
      
  @endforeach
</div>
@endsection
