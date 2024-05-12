<div class="available">
    

    
    
    
    @foreach(layout_data()->depts as $dp)
    <a href="{{ $dp->link }}">
        <div class="service">
            <div class="photo">
                <img class="img-responsive" src="{{url('/').'/'.$dp->image}}">
            </div>
            <h4>{{ $dp->name }}</h4>
        </div>
    </a>
    @endforeach
    <a href="{{ route('search') }}">
        <div class="service">
            <div class="photo">
                <img class="img-responsive" src="{{url('/')}}/assets/harag/images/search.png">
            </div>
            <h4>البحث</h4>
        </div>
    </a>
</div>