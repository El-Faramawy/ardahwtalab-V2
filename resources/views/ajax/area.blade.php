<option selected disabled>اختر المنطقة</option>
@foreach($area as $a)
	<option value="{{$a->id}}">{{$a->name}}</option>
@endforeach