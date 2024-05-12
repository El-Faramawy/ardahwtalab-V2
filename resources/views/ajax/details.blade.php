@if(isset($dept) && $dept->id && !$dept->childs()->count())
<div class="form-row subCategoy">
	<div class="label-div">
		<label for="exampleInputEmail1">الأقسام الفرعية</label>
	</div>
	<div class="input-div add-post-categ-inp">
		<select required class="selectpicker advs_dept_id" name="dept" title="اختر القسم الفرعى"
			data-id="{{ $info->id }}">
			<option value="{{ $dept->parent->id }}">الكل</option>
			@foreach($dept->parent->childs as $child)
			<option {{ $dept->id == $child->id ? 'selected' : '' }}
				value="{{$child->id}}">{{ $child->name }}</option>
			@endforeach
		</select>
	</div>
</div>
@endif

@if(isset($dept) && $dept->childs()->count())


@if(!is_null($info->first()->id))

<div class="form-row subCategoy">
	<div class="label-div">
		<label for="exampleInputEmail1">الأقسام الفرعية</label>
	</div>

	<div class="input-div add-post-categ-inp">
		<select required class="selectpicker gg advs_dept_id" name="dept" data-id="{{ $info->first()->id }}">
		        <option value="">إختر القسم الفرعي</option>

			@foreach($info as $child)
    			<option {{ ($dept->id == $child->id) ? 'selected' : ($info->first()->dept == $child->id ? 'selected' : '') }} value="{{$child->id}}">{{ $child->name }}</option>
			@endforeach
		</select>
	</div>
</div>



@else

<div class="form-row subCategoy">
	<div class="label-div">
		<label for="exampleInputEmail1">الأقسام الفرعية</label>
	</div>
	<div class="input-div add-post-categ-inp">
		<select required class="selectpicker advs_dept_id" name="dept" data-id="{{ $info->id }}">
		    <option value="">إختر القسم الفرعي</option>
			@foreach($dept->childs as $child)
			    <option  value="{{$child->id}}">{{ $child->name }}</option>
			@endforeach
		</select>
	</div>
</div>

@endif




@endif
@if(isset($props))
@foreach($props as $pr)
@if($pr->input=='select')
<div class="form-row">
	<div class="label-div">
		<label for="exampleInputEmail1">{{$pr->name}}</label>
	</div>
	<div class="input-div add-post-categ-inp">

		<select {{ $pr->main ? 'required' : '' }} class="selectpicker" title="{{ $pr->name }}" name="myoptions[{{ $pr->id }}]">
			@if($pr->types)

                @foreach($pr->types as $tp)

                <option {{ (isset($info->first()->options[$pr->id]) && $info->first()->options[$pr->id] == $tp->name)   || (!is_null(request('myoptions')) && request('myoptions')[$pr->id]) == $tp->name ? 'selected' : '' }}
                    value="{{$tp->name}}">{{ $tp->name }}</option>
                @endforeach
            @endif
		</select>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.proptype').change(function () {
			var id = $(this).val();
			var data = {
				proptype: id
			};
			var action = $("input[name='getDetails']").data('action');
			$.get(action, data, function (msg) {
				$('.advs_proptypes').html(msg);
			});
		});
	});
</script>
@else
<div class="form-row">
	<div class="label-div">
		<label for="title-input">{{ $pr->name }}</label>
	</div>
	<div class="input-div">
		<input {{ $pr->main ? 'required' : '' }} name="myoptions[{{ $pr->id }}]"
			value="{{ (!is_null(request("myoptions")) && request("myoptions")[$pr->id]) ?? $info->options[$pr->id] ?? '' }}" type="text"
			class="form-control" placeholder="{{ $pr->name }}">
	</div>
</div>

@endif
@endforeach
@elseif(isset($proptypes))
@if($proptypes->count())
@if($input->input=='select')
<div class="form-row">
	<div class="label-div">
		<label for="exampleInputEmail1">{{$input->name}}</label>
	</div>
	<div class="input-div add-post-categ-inp">
		<select class="selectpicker advs_dept_id" name="{{ $input->name }}">
			@foreach($proptypes as $pr)
			<option {{ request($input->name) == $pr->name ? 'selected' : '' }} value="{{$pr->name}}">{{$pr->name}}
			</option>
			@endforeach
		</select>
	</div>
</div>
@else @foreach($proptypes as $pr)
<div class="form-row">
	<div class="label-div">
		<label for="title-input">{{ $pr->name }}</label>
	</div>
	<div class="input-div">
		<input {{ $pr->main ? 'required' : '' }} name="myoptions[{{ $pr->id }}]"
			value="{{ $info->options[$pr->id] ?? '' }}" type="text" class="form-control" placeholder="{{ $pr->name }}">
	</div>
</div>
@endforeach @endif @endif @elseif(isset($servs)) @if(in_array('peroid',$servs))
<div class="adv-srh">
	<div class="form-group">
		<label class="control-label col-lg-2">مدة التجهيز</label>
		<div class="col-lg-10">
			<div class="input-group">

				<input class="form-control" type="number" name="peroid" placeholder="عدد بالأيام">
			</div>
		</div>
	</div>
</div>
@endif
@if(in_array('start_price',$servs))
<div class="adv-srh">
	<div class="form-group">
		<label class="control-label col-lg-2">فتح المزاد بمبلغ</label>
		<div class="col-lg-10">
			<div class="input-group">

				<input class="form-control" name="start_price" type="number" value="{{ $info->start_price }}"
					placeholder="فتح المزاد بمبلغ">
			</div>
		</div>
	</div>
</div>
@endif @if(in_array('end_date',$servs))
<div class="adv-srh">
	<div class="form-group">
		<label class="control-label col-lg-2">تاريخ انهاء المزاد</label>
		<div class="col-lg-10">
			<div class="input-group">

				<input type="date" class="form-control" name="end_date" placeholder="تاريخ انهاء المزاد">
			</div>
		</div>
	</div>
</div>
@endif @elseif(isset($area))
<div class="adv-srh">

	<select class="form-control" name="area" data-live-search="true">
		@foreach($area as $ar)
		<option value="{{$ar->id}}">{{$ar->name}}</option>
		@endforeach
	</select>
</div>
@endif

@if(isset($dept) && $dept->super_parent->slider)
<div class="form-row price-row">
	<div class="label-div">
		<label for="title-input">السعر</label>
	</div>
	<div class="input-div">
		<input name="price" value="{{ $info->first()->price }}" type="number" class="form-control" placeholder="السعر">
	</div>
</div>
@endif
<script type="text/javascript">
	jQuery(document).ready(function () {
		$('select:not(.norselect)').selectpicker('refresh');
	});
</script>
