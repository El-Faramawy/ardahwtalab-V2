<!DOCTYPE html>
<html>
<head>
	@include('site.layout.assets')
</head>
<body>
	@if(\App\Models\SiteConfig::first()->close)
		{{ \App\Models\SiteConfig::first()->close_msg }}
	@else
		@include('site.layout.header')
		@include('site.layout.side')

			<div id="content" class="col-md-9" style="padding-top: 30px !important">
				@yield('page')
				@yield('content')
			</div>
		</div>
		<input name="getDetails" type="hidden" data-action="{{route('searchdetails')}}">
		{{ csrf_field() }}
		@include('site.layout.footer')
	@endif
</body>
</html>
