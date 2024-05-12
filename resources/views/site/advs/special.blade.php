<div class="special_banners">
	<div class="container">
		<div class="banners_table">
			<h5 class="heading">
				اعلانات مميزة
			</h5>
			<div class="cells">
				@foreach($excellents as $ad)
				<div class="cell">
					<div class="photo">
						<a href="{{route('advertise.show',[$ad->id,$ad->slug])}}">
							<img src="{{$ad->images->first() ? url('/').'/'.$ad->images->first()->image : url('/').'/assets/uplaods/empty.png' }}"
							 alt="{{ $ad->title }}" class="img-responsive">
						</a>
					</div>
					<div class="detail">
						<a href="{{route('advertise.show',[$ad->id,$ad->slug])}}">{{ $ad->title }}</a>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>