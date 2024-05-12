@extends('site.index')
@section('title') ابلاغ عن مخالفة @stop
@section('page')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<h3>إبلاغ عن إعلان مخالف </h3>
	<form novalidate method="post" id="postform">
		<table class="table  tableMsg table-borderedAds tableextra">
			</tr>
			<tr>
				<td>
					<div class="alert alert-warning">
						تحذير:هذا النموذج مخصص فقط للإبلاغ عن الاعلانات المخالفه وليس للتواصل مع صاحب الاعلان
					</div>
					<div class="alert alert-info">
						<textarea name="text" id="message" placeholder="سبب المخالفة" class="form-control"></textarea>
						@if(isset($comment_id))
						<input type="hidden" name="comment" value="{{ $comment_id }}" />
						@endif
						{{ csrf_field() }}
						<br>
						<input class="btn  btn-primary" name="submit" value="إرســـال" type="submit">
					</td>
				</tr>
			</tbody></table>
		</form>
	</div>
	@stop