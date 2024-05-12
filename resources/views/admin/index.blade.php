<!DOCTYPE html>
<html lang="en" dir="rtl" lang="ar">
<head>
	@include('admin.layout.assets')
</head>

<body>

	@include('admin.layout.header')


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			@include('admin.layout.nav')

			@yield('page')

		</div>
		<!-- /page content -->

	</div>
	@include('admin.layout.footer')
</body>
</html>
