@extends('site.index')
@section('title') طلبات الاشتراك الخاصة بك @stop
@section('page')
<div id="content" class="col-md-12 nopadding">
	<div id="box-contents">
		<h1 class="box-contents-name">
			طلبات ترقية العضوية
		</h1>
		<div class="box-contents-content">
			<table class="box_cont">
				<thead>
					<th>النظام</th>
					<th>تاريخ</th>
					<th>حالة الطلب</th>
				</thead>
				@foreach($joins as $info)
				<tbody>
					<tr>
						<td>{{ \App\Models\Jointypes::find($info->type)->name }}</td>
						<td>{{ $info->created_at }}</td>
						<td>{{ $info->status }}</td>
					</tr>
				</tbody>
				@endforeach
			</table>

			<div class="clear"></div>
			<div class="clear"></div>
		</div>
		<div class="footer"></div>
	</div>
	<div class="shadow"></div>

</div>
@stop
