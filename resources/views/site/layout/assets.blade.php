<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--<meta content='IE=Edge;chrome=35+' https-equiv='X-UA-Compatible'/>-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{layout_data()->config->title}} | @yield('title')</title>

@stack('meta')
<meta name="keywords" content="{{ layout_data()->config->keywords }}">
<meta name="description" content="{{ layout_data()->config->description }}">
<link rel="shortcut icon" type="image/png" href="{{ url(layout_data()->config->favicon) }}">
<link rel="stylesheet" href="{{url('site')}}/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{url('site')}}/css/bootstrap-rtl.min.css" />
<link rel="stylesheet" href="{{url('site')}}/css/bootstrap-select.min.css" />
<link rel="stylesheet" href="{{url('site')}}/css/aos.css" />
<link rel="stylesheet" href="{{url('site')}}/css/owl.carousel.min.css" />
<link rel="stylesheet" href="{{url('site')}}/css/hover-min.css" />
<link rel="stylesheet" href="{{url('site')}}/fonts/fontawesome/css/all.min.css" />
<link href="{{ url('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{url('thamen')}}/css/style.css" />
<link rel="stylesheet" href="{{url('site')}}/css/main.css" />
@stack('styles')
<style>
.ScrollMe::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: rgb(164, 124, 124)
}

.ScrollMe::-webkit-scrollbar {
    width: 10px;
    background-color: rgb(164, 124, 124)
}

.ScrollMe::-webkit-scrollbar-thumb {
    background-color: #d1a054;
    border: 2px solid rgb(164, 124, 124)
}
</style>
<link rel="stylesheet" href="{{url('site')}}/css/custom.css?ver=1.0" />
<link rel="stylesheet" href="{{url('site')}}/front_custom.css?ver=3.96" />
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

<script src="{{ url('site') }}/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<link rel="stylesheet"
   href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<!-- cdnjs -->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/plugins/jquery.lazy.ajax.min.js"></script>-->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.10/jquery.lazy.plugins.min.js"></script>
<!--<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>-->
<!--<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js">-->
<!--</script>-->

