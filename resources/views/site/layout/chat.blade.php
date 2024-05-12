<?php
	$user_id=Auth::user()->id;
	$users=\App\Models\Chat::where('to',$user_id)->where('seen',0)->pluck('from')->toArray();
?>
<div id="box-menu">
	<div class="box-menu-title"><i class="fa fa-wechat"></i> المحادثات المباشرة</div>
	<div class="box-menu-content">
		<ul id="user-cp">
			<li>
				<i class="fa fa-wechat"></i>
				طلبات المحادثة المباشرة @if(count($users))<span class="num num_chat">{{ count($users) }}</span>@endif
			</li>
		</ul>
		@foreach($users as $us)
		<ul id="chat-with-users" style="display: block;">
			<li>
				<a class="start-chat" href="{{ route('users.chat') }}?user={{\App\Models\User::find($us)->username}}">
				<i class="fa fa-comments-o"></i>{{\App\Models\User::find($us)->username}}</a><span></span>
			</li>
		</ul>
		@endforeach
	</div>
</div>
