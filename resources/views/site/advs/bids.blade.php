<div id="adswrapper">
  <table class="table tableAds table-borderedAds ">
    <tr>
     <th> </th>
     <th>الاعلان</th>
     <th>المستخدم</th>
     <th>السعر</th>
     <th>الوقت</th>
   </tr>
   @if(isset($bids))
   @foreach($bids as $ad)
   <tr>
     <td class="ads_id" data-id="{{$ad->id}}" id="{{$ad->id}}"> </td>
     <td><a href="{{route('advertise.show',\App\Models\Advs::find($ad->advs_id)->slug)}}">
      {{\App\Models\Advs::find($ad->advs_id)->slug}}
      </a>
      <a href="{{route('advertise.show',\App\Models\Advs::find($ad->advs_id)->slug)}}">&nbsp;<i class="fa fa-camera-retro black"></i> </a>&nbsp;
     </td>
    <td> <a href="{{ route('users.show',\App\Models\User::find($ad->user_id)->username) }}" class="smallsize">{{ \App\Models\User::find($ad->user_id)->username }}</a> </td>
     <td>{{ $ad->price }}</td>
     <td>{{ $ad->created_at }}</td>
   </tr>
   @endforeach
   @endif
 </table>

</div>
