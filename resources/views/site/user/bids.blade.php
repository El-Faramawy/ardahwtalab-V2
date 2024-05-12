@extends('site.index')
@section('title') {{ $title }} @stop
@section('page')
<div id="content" class="col-md-12 nopadding"> 
	<div id="box-contents">
		<h1 class="box-contents-name">
			{{ $title }}
		</h1>
		<div class="box-contents-content"> 
			<div class="ads-s-items">
				<table>
					<thead>
						<tr>
							<th> الإعلان </th>
							<th> اعلى سعر</th>
							<th> عرض كل المزايدات </th>
						</tr>
					</thead>
					@foreach($bids as $rq)
					<tbody request="9">
						<tr>
							<td> <a href="{{ route('advertise.show',[$rq->id,$rq->slug]) }}" ajax_open="true"> {{$rq->title}} </a> </td> 
							<td> {{ $rq->bids()->orderBy('price','desc')->first()->price or '' }} </td>
							<td> <a class="btn btn-primary show-list" data-id="{{$rq->id}}"><i class="fa fa-eye"></i></a></td>
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
<input type="hidden" class="list-action" value="{{route('list-bids')}}">
<div id="list-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	
      </div>
    </div>
  </div>
</div>
@stop