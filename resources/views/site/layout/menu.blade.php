<ul class="menu">
    <li>
        <a href="{{ route('likes') }}">
            <i class="fa fa-heart-o" aria-hidden="true"></i> المفضلة</a>
    </li>
    <li>
        <div class="dropdown">
            <button class="menu-dropdown-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">
                <i class="fa fa-bell-o" aria-hidden="true"></i>الإشعارات
                @if(layout_data()->notfs->count())
                <span class="notifications-num">{{ layout_data()->notfs->count() }}</span>
                @endif
            </button>
            <ul class="dropdown-menu notifications-menu" aria-labelledby="dropdownMenu1">
                <img src="{{ url('/') }}/assets/harag/pic/top-arrow.png" />
                @if(!layout_data()->notfs->count())
                <li><p><center>عفواً لا يوجد إشعارات</center></p></li>
                @endif
                @foreach(layout_data()->notfs as $nt)
                <li>
                    <p>
                        <a class="active" href="{{ route('user.notfs') }}">
                            <i class="fa fa-caret-left" aria-hidden="true"></i>{{ strip_tags($nt->text) }}</a>
                    </p>
                </li>
                @endforeach
            </ul>
        </div>
    </li>
    <li>
        <div class="dropdown">
            <button class="menu-dropdown-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">
                <i class="fa fa-commenting-o" aria-hidden="true"></i>رسائلي
                @if(Auth::user()->msgs()->where('seen',0)->count())
                <span class="notifications-num">{{ Auth::user()->msgs()->where('seen',0)->count() }}</span>
                @endif
            </button>
            <ul class="dropdown-menu messages-menu" aria-labelledby="dropdownMenu1">
                <img src="{{ url('/') }}/assets/harag/pic/top-arrow.png" />
                @if(!layout_data()->msgs->count())
                <li style="padding:0px; color:#000;"><p><center>عفواً لا يوجد رسائل</center></p></li>
                @endif
                @foreach(layout_data()->msgs as $msg)
                <li>
                    <p>
                        <a class="active" href="{{ route('users.chat') }}">
                            <span>
                                <i class="fa fa-user-circle" aria-hidden="true"></i>{{ \App\Models\User::find($msg->from)->username }}</span>
                            <br/> {{ $msg->message or '' }}
                        </a>
                    </p>
                </li>
                @endforeach
            </ul>
        </div>
    </li>
    <li style="padding-right: 0;">
        <div class="dropdown myaccount">
            <button class="menu-dropdown-btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">
                <i class="fa fa-user-o" aria-hidden="true"></i>
                <span>مرحبا:</span>
                <span><?php echo auth()->user()->username ?></span>
                <?php /* حسابى */ ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <img src="{{ url('/') }}/assets/harag/pic/top-arrow.png" /> @include('site.layout.user-config')
            </ul>
        </div>
    </li>
</ul>
