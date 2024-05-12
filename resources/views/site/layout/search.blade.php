<div class="search-container">
     
      <span class="search-title">البحث</span>
<form novalidate class="sh-form" action="{{ route('search') }}" method="get" @if(Route::currentRouteName()=='search') id="srh-form" @endif>
      
      <select class="selectpicker" data-style="btn-defult" title="القسم" name="dept" id="advs_dept_id">
        @foreach(layout_data()->depts as $dp)
          <option value="{{ $dp->id }}">{{ $dp->name }}</option>
        @endforeach
      </select>



      <select class="selectpicker" data-style="btn-defult" title="المدينة" name="area">
        @foreach(layout_data()->area as $ar)
          <option value="{{ $ar->id }}">{{ $ar->name }}</option>
        @endforeach
      </select>
      
      <div>
          <input class="form-control" placeholder="كلمة البحث" name="title" />
      </div>

      <div class="search-btn"><button type="submit" class="sh-sub><i class="fa fa-search"></i>بحث</button></div>

    </form>
</div>