<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ site_config()->title }} - @yield('title')</title>
<link rel="shortcut icon" type="image/png" href="{{ url('/').'/'.site_config()->favicon }}">
<!-- Global stylesheets -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">

<link href="{{ url('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{url('/')}}/assets/admin/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
<link href="{{url('/')}}/assets/admin/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="{{url('/')}}/assets/admin/css/core.css?ver=1.1" rel="stylesheet" type="text/css">
<link href="{{url('/')}}/assets/admin/css/components.css" rel="stylesheet" type="text/css">
<link href="{{url('/')}}/assets/admin/css/colors.css" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/admin/datatable/datatable.css">
<!-- Core JS files -->
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/libraries/jquery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/libraries/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/loaders/blockui.min.js"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/visualization/d3/d3.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/visualization/d3/d3_tooltip.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/forms/styling/switchery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/forms/styling/uniform.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/pickers/daterangepicker.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/libraries/jquery_ui/full.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/plugins/forms/selects/select2.min.js"></script>

<script type="text/javascript" src="{{url('/')}}/assets/admin/js/core/app.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/admin/js/pages/form_select2.js"></script>
<!-- /theme JS files -->



<script type="text/javascript" src="{{url('/').'/assets/admin/ckeditor/ckeditor.js'}}"></script>
<script src="{{url('/').'/assets/admin/ckeditor/samples/js/sample.js'}}"></script>
<link href="{{url('/').'/assets/admin/fileinput/css/fileinput.css'}}" media="all" rel="stylesheet" type="text/css" />
<script src="{{url('/').'/assets/admin/fileinput/js/fileinput.js'}}" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/bootstrap-select/dist/css/bootstrap-select.css">
<script type="text/javascript" src="{{url('/')}}/assets/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script type="text/javascript" src="{{url('/')}}/assets/ajax.js"></script>

<link href="{{url('/')}}/assets/bootstrap-switch/docs/css/highlight.css" rel="stylesheet">
<link href="{{url('/')}}/assets/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
<link href="{{url('/')}}/assets/bootstrap-switch/docs/css/main.css" rel="stylesheet">
<script src="{{url('/')}}/assets/bootstrap-switch/dist/js/bootstrap-switch.js"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDGYH1WajbEd1Wvq_-VSy2YrKYG5YbG45E&sensor=false&libraries=places&language=ar'></script>
<script src="{{url('/')}}/assets/locationpicker/src/locationpicker.jquery.js"></script>
<script type="text/javascript" src="{{url('/').'/assets/admin/js/helper.js'}}"></script>

<script type="text/javascript" src="{{url('/')}}/assets/tags/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/tags/jquery.tagsinput.min.css" />
@stack('assets')
