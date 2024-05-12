<div id="adswrapper">
  <table class="table tableAds table-borderedAds ">
    <tr>    
     <th> </th>
     <th>العروض</th>
     <th>المدينة</th>
     <th>المعلن</th>
     
     <th>قبل</th>
   </tr>
   @if(isset($likes))
   @foreach($likes as $ad) 
   <div class="net-col">
      <div class="pr-block wow fadeInUp">
        <div class="pr-img">
          <a href="{{route('advertise.show',[$ad->id,$ad->slug])}}">
            <img class="img-responsive" src="{{url('/').$ad->image}}">
          </a>
        </div>
        <div class="pr-info">
        <a class="pr-ress" href="{{route('advertise.show',[$ad->id,$ad->slug])}}">{{ $ad->title }}</a>
          <div class="pr-details">
            <a href="{{route('area',$ad->area->name)}}">
              <span class="pr-place">{{ $ad->area->name }}</span>
            </a>
            <a href="{{ $ad->dept->link }}">
              <span class="pr-type">{{ $ad->dept->name }}</span>
            </a>
            <span class="pr-comment">{{ time_ago($ad->created_at) }}</span>
          </div>
          <div class="pr-avatar">
            <div class="avatar-img">
              <a href="{{ route('users.show',$ad->user->username) }}"><img class="img-responsive" src="{{url('/').$ad->user->image}}" alt="avatar"></a>
            </div>
            <a class="avatar-ress" href="{{ route('users.show',$ad->user->username) }}">{{ $ad->user->username }}</a>
          </div>
          <div class="pr-time">
            <span><i class="fa fa-clock-o"></i> {{ time_ago($ad->created_at) }}</span>
          </div>
        </div>
      </div>
    </div>
   @endforeach 
   @endif
 </table>
 
</div>