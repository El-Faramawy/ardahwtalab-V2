<style>
    /*.like-btn {*/
    /*    position: relative !important;*/
    /*    top: 0px;*/
    /*    right: 1px;*/
    /*}*/
</style>
<ul class="lisr-unstyled list-inline p_actions">
    <li>
        <i class="fas fa-bookmark"></i>
        {{ $info->status }}
    </li>
    <li><i class="fas fa-map-marker-alt"></i> {{ $info->getarea->name }} </li>
    <li><i class="far fa-clock"></i> {{ time_ago($info->created_at) }} </li>
    @if(Auth::check())
    @if(Auth::user()->id != $info->user->id)
    <?php $islike = islike($info->id); ?>
    <li>
        <a class="btn-like SSA-Like {{ $islike ? 'active' : '' }}"
           href="{{ route('like',$info->id) }}">
            <i class="fa fa-heart" aria-hidden="true"></i>
            <span class="text SA">
                @if($islike)
                حذف من المفضلة
                @else
                أضف إلى المفضلة
                @endif
            </span>
        </a>
    </li>

    <li>
        <a href="{{ route('advertise.claims',$info->slug) }}">
            <i class="fa fa-flag" aria-hidden="true"></i> إبلاغ عن المخالفات
        </a>
    </li>

    @endif

    @else
    <li>
        <a data-toggle="modal" data-target="#signIn-modal">
            <i class="fa fa-heart" aria-hidden="true"></i> أضف إلى المفضلة
        </a>
    </li>
    <li>
        <a data-toggle="modal" data-target="#signIn-modal">
            <i class="fa fa-flag" aria-hidden="true"></i> إبلاغ عن المخالفات
        </a>
    </li>
    @endif

    @if(Auth::check())
    @if(Auth::user()->id == $info->user->id)
    <li>
        <a href="{{ route('advertise.actions',[$info->id,$info->slug]) }}?type=refresh">
            <i class="fa fa-refresh" aria-hidden="true"></i>تحديث الإعلان
        </a>
    </li>
    <li>
        <a href="{{ route('advertise.edit',$info->id) }}">
            <i class="fa fa-times" aria-hidden="true"></i>تعديل الإعلان
        </a>
    </li>
    <li>
        <a id="btn-remove-advs"
           data-href="{{ route('advertise.destroy',[$info->slug,$info->id]) }}">
            <i class="fa fa-trash" aria-hidden="true"></i>حذف الإعلان
        </a>
    </li>
    @endif
    @endif
</ul>