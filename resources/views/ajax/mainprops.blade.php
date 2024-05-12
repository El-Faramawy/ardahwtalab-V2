<option value="0">رئيسى</option>
@foreach($props as $p)
	<option value="{{$p->id}}">{{$p->name}}</option>
@endforeach