@extends('site.index')
@section('title') {{ $title }} @stop
@section('page')
<div id="content" class="col-md-12 nopadding">

	<div id="box-contents">
		<h1 class="box-contents-name">
			{{ $title }}
		</h1>
		<div class="box-contents-content">
			<div class="ui-widget">
				<div align="center" class="ui-state-highlight ui-corner-all" style="padding:5px;">
					<p>
						<strong>
							لن يتم باى حال من الأحوال توصيل سلع أو منتجات لك إلا إذا كنت قدم أرسل كامل المبلغ المطلوب منك
						</strong>
					</p>
				</div>
			</div>
			<div class="ads-s-items">
				<table>
					<thead>
						<tr>
							<th> الإعلان </th>
							<th> صاحب الإعلان </th>
							<th> العُمله </th>
							<th> السعر </th>
							<th> العمولة المطلوبة </th>
							<th> المبلغ المطلوب إرسالة </th>
							<th> هل وصل الشحن ؟! </th>
							<th> حالة الطلب </th>
						</tr>
					</thead>
					@foreach($requests as $rq)
					<tbody request="9">
						<tr>
							<td> <a href="{{ route('advertise.show',[$rq->advertise->id,$rq->advertise->slug]) }}" ajax_open="true"> {{$rq->advertise->title}} </a> </td>
							<td> {{ $rq->user->username }} </td>
							<td>  ريال سعودى </td>
							<td> {{ $rq->advertise->price }}  </td>
							<td> {{ \App\Models\Advs_config::first()->commision_buyer }} </td>
							<td> {{ \App\Models\Advs_config::first()->commision_buyer+$rq->advertise->price }} </td>
							<td>
								@if(!$rq->status)
								<a href="{{route('users.requests',$rq->id)}}">تم استلام المبلغ</a>
								@else
									نعم
								@endif
							</td>
							<td>
								@if(!$rq->status)
								بأنتظار وصول المبالغ
								<a href="{{ route('banking') }}" ajax_open="true" class="south" original-title="يجب دفع كامل المبلغ المطلوب حتى يتم الأنتقال للمرحلة التالية فى الطلب">  طرق الدفع  </a>
								@else
									تم أنتهاء المعاملة بنجاح تقييم العضو <a href="{{route('users.show',$rq->user->username)}}">{{ $rq->user->username }}
								@endif
							</td>
						</tr>
					</tbody>
					@endforeach
				</table>
			</div>
			<div class="clear"></div>
			<div class="clear"></div>

		</div>
	</div>
</div>
@stop
