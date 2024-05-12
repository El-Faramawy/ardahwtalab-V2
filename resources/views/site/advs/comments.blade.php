<div class="post-comments add_notes">
    <p class="comments-h">التعليقات</p>
    @foreach($info->comments as $cm)

    <div class="row comment">
        <a href="{{ route('users.show',$cm->user->username) }}">
            <img src="{{ url('') }}/{{ $cm->user->image }}" />
        </a>
        <div>
            <a href="{{ route('users.show',$cm->user->username) }}">{{ $cm->user->username }}</a>
            <p>{{ $cm->comment }}</p>
        </div>
    </div>
    @endforeach 
    @if(!$info->comments()->count())
    <center><h4 style="color:#aaa">عفواً لا يوجد تعليقات حتى الآن !</h4></center>
    @endif
    @if(Auth::check()) 
    @if(Auth::user()->id != $info->user->id)
    <?php /* <hr /> */ ?>
    <p class="comments-h lab">إضافة تعليق</p>
    <form novalidate class="comment-form" action="{{route('comment')}}" method="post">
        <textarea rows="4"  class="note" name="comment" required placeholder="اكتب نص التعليق هنا"></textarea>
        <input type="hidden" name="advs_id" value="{{ $info->id }}"> {{ csrf_field() }}
        <div class="plus_add">
            <button type="submit">إضافة</button>
        </div>
        <?php /* <button class="hvr-rectangle-in" type="submit">تعليق</button> */ ?>
    </form>
    @endif 
    @else
    <?php /* <hr /> */ ?>
    <p class="comments-h lab">إضافة تعليق</p>
    <form novalidate class="comment-form" action="{{route('comment')}}" method="post">
        <textarea class="note" name="comment" required placeholder="اكتب نص التعليق هنا"></textarea>
        <input type="hidden" name="advs_id" value="{{ $info->id }}"> {{ csrf_field() }}
        <div class="plus_add">
            <button type="submit">إضافة</button>
        </div>
        <?php /* <a class="hvr-rectangle-in" data-toggle="modal" data-target="#signIn-modal">تعليق</a> */ ?>
    </form>
    @endif
</div>
