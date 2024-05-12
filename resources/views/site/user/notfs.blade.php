@extends('site.user.profile')
@section('ptitle') الإشعارات @stop
@section('part')
	<div class="col-sm-8 col-lg-9">
		<div class="profile-body">
			<p class="profile-h">الإشعارات</p>
			<div class="notifications-div">
				<ul class="notification-menu">
					@foreach($notfs as $nt)
					<li class="{{ $nt->seen ? '' : 'active' }}"><i class="fa fa-caret-left" aria-hidden="true"></i><a href="{{ $nt->link }}?show=1">{{ strip_tags($nt->text) }}</a> {{ $nt -> created_at }}
				
					
					</li>
					@endforeach
				</ul>
			</div>
			<div class="text-center m-20">
                {{ $notfs->links() }}
            </div>
		</div>
	</div>
@stop