@foreach($lists as $a)
	<option value="{{$a->id}}">{{$a->fullname}}</option>
@endforeach