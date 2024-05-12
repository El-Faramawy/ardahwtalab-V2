@extends('site.user.profile')
@section('ptitle') الدردشة @stop
@section('part')

@php $dates = [] @endphp
<div class="col-sm-8 col-lg-9">
    <h2>الدردشة مع : {{ $chat_user->username }}</h2>
    <div class="messages-menu-div">
        <ul class="messages-menu">
            @foreach($chat as $ch)
            <li class="{{ $ch->seen ? '' : 'active' }}">
                @if(!in_array($ch->sent_date , $dates))
                <h5 class="sent_date">{{ $ch->sent_date }}</h5>
                @php $dates[] = $ch->sent_date @endphp
                @endif
                @if(\App\Models\User::find($ch->from)->image)
                <img width="50" height="50" src="{{\App\Models\User::find($ch->from)->image}}">
                @else
                <i class="fa fa-user"></i>
                @endif

                <p class="mess-h">
                    @if(!is_null(\App\Models\User::find($ch->from)->documentation))
                        @if(\App\Models\User::find($ch->from)->documentation->activeted == 1)
                            <i class="fa fa-star" style="color:green;"></i>
                        @endif
                    @endif
                    {{ \App\Models\User::find($ch->from)->username }} &nbsp; &nbsp; <span class="sent_time">{{ $ch->sent_time }}</span></p>
                <p class="mess-body">{{ $ch->message }}</p>
                <div class="msg_seen">
                    @if($ch->seen)
                    <img src="{{ url('double-check.png') }}" />
                    @else
                    <img class="notseen" src="{{ url('check.png') }}" />
                    @endif
                </div>
            </li>
            <?php
                if(auth()->user()->id == $ch->to){
                    \App\Models\Chat::where('id', $ch->id)->update(['seen' => '1']);
                }
            ?>
            @endforeach
        </ul>
    </div>
    <hr />
    <div class="chat-form">
        <form novalidate action="{{ route('users.chat',$userid) }}" method="post">
            <input type="hidden" name="to_id" value="{{ $user_id }}">
            <textarea class="form-control" name="message"></textarea><br />
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger">ارسال</button>
        </form>
    </div>
</div>

<script>
$('.messages-menu-div').scrollTop($('.messages-menu-div')[0].scrollHeight);
</script>
@stop
