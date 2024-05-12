<div class="col-sm-12" style="float: left;">
    <div class="banners">
    	@foreach(layout_data()->bottom_posters as $poster)
        <div class="banner1">
           <a target="blank" href="{{ $poster->link }}"><img class="img-responsive" title="{{ $poster->title }}" src="{{ url('/').'/'.$poster->image }}"></a>
        </div>
        @endforeach
    </div>
</div>