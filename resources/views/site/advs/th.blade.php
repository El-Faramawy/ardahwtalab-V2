
    <tr>    
     <th> </th>
     <th>العروض</th>
     <th>المدينة</th>
     <th>المعلن</th>
     
     <th>قبل</th>
     @if(Auth::check())
       @if(Route::currentRouteName()=='users.show')
         @if(Auth::user()->id==$info->id)
            <th>اغلاق الاعلان</th>
           <th>تعديل</th>
           <th>حذف</th>
         @endif
       @endif
     @endif
   </tr>