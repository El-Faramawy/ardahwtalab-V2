@extends('site.index') @section('title') الاعضاء المتابعين @stop @section('page')
<div id="content" class="col-md-12 nopadding">

    <div id="box-contents">
        <h1 class="box-contents-name" style="padding-bottom:30px;">
            <center>
                الاعضاء المتابعين
            </center>
        </h1>
        <div class="box-contents-content row followers">
            <?php foreach ($followers as $f): ?>
                <?php
                if (!$f) {
                    continue;
                }
                ?>
                <div class="col-md-2 col-sm-3" style="box-shadow: 0 0 2px 0px black;padding: 0px;border-radius: 3px;margin-left: 15px;">
                        <img src="{{ url('/').'/'.$f->follower->image }}" style=" width: 100%; height: 100px; "/>
<a style=" background: #0d2043; padding: 10px; color: white;" class="panel-h follow-user-btn" href="{{ route('users.follow',$f->follower->id) }}">
<i class="fa fa-rss"></i>
<span>
إلغاء المتابعة 
 </span> 
 </a>
<a href="{{ route('users.show',$f->follower->id) }}" style="text-align: center;">
                            <h3>{{ $f->follower->username }}</h3>
                        </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
@stop