<link rel="stylesheet" href="{{ url('/') }}/assets/harag/sweetalert2/sweetalert2.min.css">
<script src="{{ url('/') }}/assets/harag/sweetalert2/sweetalert2.min.js"></script>
@if(isset($error))
	<script>swal({html : "{{ $error }}", type : "error" , confirmButtonText : "موافق"});</script>
@endif
@if(isset($true))
	<script>swal({html:"{{ $true }}", type :"success" , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('message') || Session::has('message'))
	<script>swal({html:"{{ session('message') }}", type:"success" , confirmButtonText : "موافق"});</script>
@endif

@if(session()->has('status') || Session::has('status'))
	<script>swal({html:"{{ session('status') }}", type:"success" , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('success') || Session::has('success'))
	<script>swal({html:"{{ session('success') }}", type:"success"  , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('error') || Session::has('error'))
	<script>swal({html:"{!! (string) is_array(session('error')) ? session('error')[0] : session('error') !!}", type:"error" , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('true') || Session::has('true'))
	<script>swal({html:"{{ session('true') }}",type:"success" , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('warning') || Session::has('warning'))
	<script>swal({html:"{{ session('warning') }}",type:"warning" , confirmButtonText : "موافق"});</script>
@endif
@if(!empty($errors->all()))
	<script>
	swal({
		html:"@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach",
		type:"error"
	});
	</script>
@endif
@if(session()->has('trueSignup'))
	<script>swal({html:"تم تسجيل حسابك بنجاح ... أهلا بك معنا متطوعاً فى جمعية نماء", type:"success" , confirmButtonText : "موافق"});</script>
@endif
@if(session()->has('sccuess_init'))
	<script>swal({html:"تم تقديم طلب إشتراكك بنجاح سيتم مراجعتة من قبل الإدارة والموافقة علية", type:"success" , confirmButtonText : "موافق"});</script>
@endif

@if(session()->has('title'))
<script>
swal({
	title:"{{ session('title') }}" , 
	text : "{{ session('text') }}",
	type:"success" , 
	confirmButtonText : "موافق"
}).then((result) => {
	window.location = "{{ url('/') }}";
});
</script>
@endif