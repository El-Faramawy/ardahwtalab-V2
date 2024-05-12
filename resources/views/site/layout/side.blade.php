<div class="col-md-4">
	@if(Auth::check()) 
		@include('site.layout.user-config') 
	@endif 
	
	@foreach(layout_data()->left_posters as $poster)
	<div class="banner">
		<a href="{{ $poster->link }}">
			<img src="{{ url('/').$poster->image }}" class="img-responsive" alt="banner">
		</a>
	</div>
	@endforeach
	<div class="common_cat">
		<h5 class="heading">
			الأقسام الشائعة
		</h5>
		<div class="common_content">
			@foreach(layout_data()->meta_depts as $dept)
			<div class="cats">
				<div class="title">
					<h5>
						<i class="fa fa-angle-left" aria-hidden="true"></i>{{ $dept->name }}</h5>
					<a class="view" href="{{ route('advs.last',['dept'=>$dept->id]) }}">عرض جميع الإعلانات</a>
				</div>
				<div class="content">
					@foreach($dept->metas as $meta)
					<a href="{{ route('advs.last',['keyword'=>$meta]) }}" class="go">{{$meta }}</a>
					@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>