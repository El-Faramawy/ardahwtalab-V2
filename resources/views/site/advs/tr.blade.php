<tr>
   <td class="ads_id" data-id="{{$ad->id}}" id="{{$ad->id}}"> </td>
   <td><a href="{{route('advertise.show',[$ad->id,$ad->slug])}}">{{$ad->title}}</a><a href="{{route('advertise.show',[$ad->id,$ad->slug])}}">&nbsp;<i class="fa fa-camera-retro black"></i> </a>&nbsp;
   </td>
   <td>
     @if(isset($ad->area))
     <a href="{{route('area',$ad->area->name)}}" class="smallsize">{{ $ad->area->name }}</a>
     @endif
   </td>
   <td> <a href="{{ route('users.show',$ad->user->username) }}" class="smallsize">{{ $ad->user->username }}</a> </td>
   <td>{{ time_ago($ad->created_at) }}</td>
   @if(Auth::check())
     @if(Auth::user()->id==$ad->user_id && Route::currentRouteName()=='users.show')
      <td><a href="{{route('advertise.edit',$ad->slug)}}?pro=close" class="btn btn-warning"><i class="fa @if($ad->closed) fa-unlock @else fa-lock @endif"></i></a></td>
       <td><a href="{{route('advertise.edit',$ad->slug)}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
       <td><a data-id="{{$info->id}}" class="btn btn-danger remove-advs"><i class="fa fa-trash"></i></a></td>
     @endif
   @endif
 </tr>   