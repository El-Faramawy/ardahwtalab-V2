<ul class="fixall list-unstyled cats-filter seemore-menu marks-filter">
      <li class="fixall mark-li"><a href="{{ $current_dept->super_parent->full_link }}"
              class="fixall mark-filter">جميع
              إعلانات {{ $current_dept->super_parent->name }}</a><span
              class="count">{{ $current_dept->super_parent->all_advs->count() }}</span>
      </li>
      @php $dept = $current_dept->super_parent; @endphp
      @while($dept && $dept->childs()->count())
         @foreach($dept->childs as $child)
         <li class="fixall mark-li"><a href="{{ $child->full_link }}"
               class="fixall mark-filter {{ $current_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a><span
               class="count">{{ $child->all_advs->count() }}</span></li>
               {{ dd($child->id) }}
               @while(in_array($child->id , $parents))
                  @php
                     $dept =  $child;
                     $key = array_search($parents , $dept->id);
                     if($dept) unset($parents[$key]);
                  @endphp
                  @foreach ($dept->childs as $child)
                  <li class="fixall mark-li"><a href="{{ $child->full_link }}"
                        class="fixall mark-filter {{ $current_dept->id == $child->id ? 'active' : '' }}">{{ $child->name }}</a><span
                        class="count">{{ $child->all_advs->count() }}</span></li>
                  @endforeach
               @endwhile
         @endforeach
      @endwhile
  </ul>