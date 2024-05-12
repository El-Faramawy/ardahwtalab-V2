
<!-------------start main-slider-------------->
<div class="slider">
        <div class="owl-carousel gallery">
        @foreach($sliders as $slide)
            <div class="image">    
                 <a href="{{ route('advertise.show',[$slide->id,$slide->slug]) }}"><img src="{{$slide->images->first() ? url('/').$slide->images->first()->image : url('/').'/assets/uplaods/empty.png' }}" alt="image"/></a>
            </div>
        @endforeach

        </div>     
 </div>
 <!-------------end main-slider-------------->