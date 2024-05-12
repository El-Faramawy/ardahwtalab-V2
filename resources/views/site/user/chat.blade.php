@extends('site.user.profile')
@section('ptitle') الرسائل @stop
@section('part')
<div class="col-sm-8 col-lg-9">
    <div class="profile-body">
        <p class="profile-h">الرسائل</p>
        <div class="messages-menu-div">
            <ul class="messages-menu">
                <?php $users = [auth()->user()->id]; ?>
                @foreach($chat as $ch)
                <?php Auth::user()->id == $ch->to ? $userid = $ch->from : $userid = $ch->to; ?>
                @if(!in_array($userid , $users))
                <li style="cursor:pointer" class="chat-with {{ has_unseen_messages($userid) ? 'active' : '' }}">
                    <a href="{{ route('users.chat',$userid)  }}">

                        @if(\App\Models\User::find($userid)->image)
                        <img width="50" height="50" src="{{ \App\Models\User::find($userid)->image}}">
                        @else
                        <i class="fa fa-user"></i>
                        @endif
                        <p class="mess-hs">
                        @if(!is_null(\App\Models\User::find($userid)->documentation))
                            @if(\App\Models\User::find($userid)->documentation->activeted == 1)
                                <i class="fa fa-star" style="color:green;"></i>
                            @endif
                        @endif
                        {{ \App\Models\User::find($userid)->username }}
                        </p>
                        <p class="mess-body">{{ $ch->message }}</p>
                    </a><hr>
                    {{ $ch -> created_at }}
                </li>
                <?php $users[] = $userid; \App\Models\Chat::where('id', $ch->id)->update(['seen' => '1']); ?>
                @endif
                @endforeach
            </ul>
            {{ $chat->links() }}
        </div>
    </div>
</div>


@stop
