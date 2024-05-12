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
    @foreach($members as $member)
  <div class="col-sm-6 col-md-4" height="500px">
    <div class="thumbnail">
      <div class="caption">
        <h3 >{{ $member->title }}</h3>
        <br/>
        <p style="text-align:right  !important;that-property: inherit">{!! $member->descr !!}</p>
        <span> المدة الزمنية : </span>
        <span>{{ $member->time  }} </span>
        <span> أشهر </span>
        
        <form class="price-calc" method="post" action="{{ route('store_Dex') }}" id="form{{$member->id}}">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="member_id" value="{{ $member->id }}">

            <input type="hidden" name="user_id" value="{{ $user->id }}">

        
        </form>
        <p class="addPost">
        المبلغ : {{$member->price  }} ريال
    </p>
        <p><input type="submit" form="form{{$member->id}}" class="btn btn-primary" role="button" style="background-color: #6d1c1c" value="اشترك"></p>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
