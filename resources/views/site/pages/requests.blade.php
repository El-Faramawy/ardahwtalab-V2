@extends('site.index')
@section('title') الطلبات @stop
@section('page')
	<!-- start orders -->
<div class="orders hidden-xs wow fadeInUp">
	<table class="table table-striped">
	    <thead>
		    <tr>
		        <th>الطلبات</th>
		        <th>المدينة</th>
		        <th>المعلن</th>
		        <th>قبل</th>
		    </tr>
	    </thead>
	    <tbody>
	    @foreach($last_requests as $rq)
	      <tr>
	        <td>
	        	<span>{{ $rq->id }}</span>
	        	<a href="{{route('advertise.show',[$rq->id,$rq->slug])}}">
	        		{{ $rq->title }}
	        	</a>
	        </td>
	        <td><a href="{{route('area',$rq->getarea->name)}}">{{ $rq->getarea->name }}</a></td>
	        <td><a href="{{route('users.show',$rq->user->username)}}">{{ $rq->user->username }}</a></td>
	        <td>{{ time_ago($rq->created_at) }}</td>
	      </tr>
	      @endforeach
	    </tbody>
	</table>
	{{ $last_requests->links() }}
</div>
<!-- end orders -->
@stop