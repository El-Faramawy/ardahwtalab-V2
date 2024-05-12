@if(Session::has('error'))

	<div class="alert alert-warning">{{ Session::get('error') }}</div>

@endif

@if(Session::has('success'))

	<div class="alert alert-success">{{ Session::get('success') }}</div>

@endif
@if($info->gettype)
	@if($info->gettype->id==10 && Auth::check())

		<div id="box-contents">

			<center><h1 class="box-contents-name">المشاركة بالمزاد</h1></center><br />
			<div class="col-sm-12 highest-bid">
				@if($info->bid_high_price)<li> <i class="fa fa-gavel"></i> أعلى سعر : {{ $info->bid_high_price }}</li>@endif

			</div>

		@if(!$info->bid_user)

		<form novalidate action="{{route('bids')}}" method="post">

			<input type="hidden" name="advs_id" value="{{$info->id}}">

			<input style="margin-bottom: 5px;" placeholder="السعر" type="number" required name="price" min="{{$info->start_price}}" class="form-control">

			<textarea style="margin-bottom: 5px;" placeholder="التفاصيل" name="details" class="form-control"></textarea>

			<button type='submit' class="sh-sub">المشاركة بالمزاد</button>

			{{ csrf_field() }}

		</form>

		@endif

		</div>

	@endif
@endif

<br />