<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>تسجيل الدخول للوحة التحكم</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('/')}}/assets/admin/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="{{url('/')}}/assets/admin/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="{{url('/')}}/assets/admin/css/core.css" rel="stylesheet" type="text/css">
	<link href="{{url('/')}}/assets/admin/css/components.css" rel="stylesheet" type="text/css">
	<link href="{{url('/')}}/assets/admin/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/app.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					<form method="post">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
							</div>
							@if(Session::has('error'))
							<div class="alert alert-warning">
								هناك خطأ فى البريد الإلكترونى أو كلمة المرور
							</div>
							@endif
							<div class="form-group has-feedback has-feedback-left">
								<input required type="email" class="form-control" name="email" placeholder="Email">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input required min="6" type="password" class="form-control" name="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
							{{ csrf_field() }}
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-left2 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /simple login form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
</body>
</html>
