<div class="slider">
    <div class="mainslider owl-carousel">
        @foreach(layout_data()->sliders as $slider)
        <div class="slideitem">
            <a href="{{ $slider->link }}"><img class="img-responsive" src="{{ url('/').'/'.$slider->image }}" title="{{ $slider->title }}"></a>
        </div>
        @endforeach
    </div>
</div>