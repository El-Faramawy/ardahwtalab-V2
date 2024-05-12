<style>
   table {
      border-spacing: 0px;
   }

   th,
   td {
      border: solid 1px #eee;
      padding: 10px;
   }
   th{
      width: 20%;
   }
</style>
<table style="width:100%;" dir="rtl">
   <tr>
      <th colspan="2">
         <img src="{{ url(site_config()->logo) }}" alt="">
      </th>
   </tr>
   <tr>
      <th>عنوان الإعلان</th>
      <td>{{ $info->title }}</td>
   </tr>
   <tr>
      <th>تاريخ الإعلان</th>
      <td>{{ $info->created_at }}</td>
   </tr>
   <tr>
      <th>الوصف</th>
      <td style="word-break: break-word;">{{ $info->description }}</td>
   </tr>
   <tr>
      <th>خصائص الإعلان</th>
      <td>
         @foreach($info->titles as $title => $options)
         <h3 class="table-title fixall">{{ $title }}</h3>
         <ul>
            @foreach($options as $name => $val)
            <li class="table-item">{{ $name }} ({{$val }})</li>
            @endforeach
            
             
            
            
            
         </ul>
         @endforeach
      </td>
      
     
      
      
   </tr>
   
    
  
      @if($info->show_phone)
      <tr>
          <th>رقم الهاتف</th>
      <td>
            {{$info->user->phone}}
      </td>
      </tr>
             @endif
   @if($info->price)
   <tr>
      <th>السعر</th>
      <td>{{ $info->price }}</td>
   </tr>
   @endif
   
   @if($info->images()->count())
   <tr>
      <th>الصور</th>
      <td>
         @foreach($info->images as $image)
         <img src="{{ asset($image->image) }}" style="height:150px; float:right; margin:5px;">
         @endforeach
      </td>
   </tr>
   @endif
</table>
<script>
   window.print();
   window.onafterprint = window.close;
</script>