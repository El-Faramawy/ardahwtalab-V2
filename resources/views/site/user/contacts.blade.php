@extends('site.index')

@section('title') تعديل بيانات التواصل @stop

@section('page')

<h1 class="box-contents-name">تعديل بيانات التواصل</h1>

	<div class="box-contents-content signup">

		<section class="col-md-12">
	<form novalidate method="post" action="{{route('contacts')}}">

		

		@foreach($contacts as $ct)

			<ul class="row form-group">

				<li class="col-sm-5">

					<select class="form-control norselect" data-live-search="true" name="type[]" title="حدد النوع">

						@foreach(contactTypes() as $key=>$tp)

							<option @if($key==$ct->type) selected @endif value="{{ $key }}">{{ $tp }}</option>

						@endforeach

					</select>

				</li>

				<li class="col-sm-6">

					<input name="value[]" class="form-control" value="{{ $ct->value }}" />

					<input type="hidden" name="id[]" value="{{$ct->id}}">

				</li>

				<li>

					<button type="button" class="remove-contact btn-danger btn" data-id="{{ $ct->id }}">

						<i class="fa fa-trash"></i>

					</button>

				</li>

			</ul>

		@endforeach

		<ul class="row">

			<li class="col-sm-5">

				<select class="form-control norselect" data-live-search="true" name="type[]" title="حدد النوع">

					@foreach(contactTypes() as $key=>$tp)

						<option value="{{ $key }}">{{ $tp }}</option>

					@endforeach

				</select>

			</li>

			<li class="col-sm-6">

				<input name="value[]" class="form-control" />

				<input type="hidden" name="id[]" value="0">

			</li>

			<li>

				<button type="button" class="remove-contact btn-danger btn">

					<i class="fa fa-trash"></i>

				</button>

			</li>

		</ul>

		<div class="contacts-content"></div>

		<div class="contacts-row">

			<ul class="row form-group">

				<li class="col-sm-5">

					<select class="form-control norselect" name="type[]" data-live-search="true" title="حدد النوع">

						@foreach(contactTypes() as $key=>$tp)

							<option value="{{ $key }}">{{ $tp }}</option>

						@endforeach

					</select>

				</li>

				<li class="col-sm-6">

					<input name="value[]" class="form-control" />

					<input type="hidden" name="id[]" value="0">

				</li>

				<li>

					<button type="button" class="remove-contact btn-danger btn">

						<i class="fa fa-trash"></i>

					</button>

				</li>

			</ul>
			<script type="text/javascript">
				$('.remove-contact').click(function(e) {
			        e.preventDefault();
			        e.stopImmediatePropagation();
			        var btn=$(this);
			        var action=$('#remove-c-action').val();
			        var id=btn.data('id');
			        var token=$("input[name='_token']").val();
			        if(!id){
			            btn.parent().parent().hide();
			        }else{
			            $.post(action,{id:id,_token:token},function(result){
			              btn.parent().parent().hide();  
			            });
			        }
			        return false;
			    });
			</script>

		</div>

		<hr />

		<a class="add-more-contacts" style="cursor: pointer;">

			<i class="fa fa-plus"></i> اضافة المزيد

		</a>

		<hr />
						<button type="submit" class="btn form-control submitButton">تعديل</button>
				

		{{ csrf_field() }}

	</form>



	<input type="hidden" id="remove-c-action" value="{{route('contacts')}}?type=remove">
	</section>
	</div>

@stop