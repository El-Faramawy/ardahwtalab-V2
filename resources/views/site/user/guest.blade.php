@extends('site.index')
@section('title')
<!--@if(auth()->check()) {{ $info->username }}  @endif -->
@stop
@section('page')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
<!-- start results section -->
<section class="results-section">
    <div class="container">
        <div class="results-content">
            <div class="profile-guest">
                <h3 style="margin-bottom:30px;">
                    @if(!is_null($info->documentation))
                        @if($info->documentation->activeted == 1)
                            <i class="fa fa-star" style="color:green;"></i>
                        @endif
                    @endif
                    @if(auth()->check())
                    {{ $info->username }}
                    @endif
                    <?php
                        $rates = GetUserRate($info);
                    ?>
                    @for($i = 0; $i < $rates; $i++)
                        <i class="fa fa-star" style="color:#abab00;"></i>
                    @endfor
                    @for($i = 5; $i > $rates;$i--)
                        <i class="fa fa-star" style="color:black;"></i>
                    @endfor
                </h3>
                <a class="chat-with-user" href="{{ route('users.chat',$info->id)  }}"><i class="fa fa-comment"></i> تحدث
                    مع المستخدم</a>
                @if(auth()->check())
                    <?php
                        $d = \App\Models\Rates::where(['user_id'=>\Auth::user()->id,'user_rated'=>$info->id])->first();
                    ?>
                    @if(is_null($d))
                        <hr/>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">تقيم</button>
                        <hr/>
                    @endif
                @endif
            </div>

            <div>
                <h3>آخر إعلانات أضافها</h3>
                @include('site.advs.list')
            </div>

        </div>
    </div>
</section>
<!-- end results section -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">تقيم العضو</h4>
      </div>
      <form method="post" action="{{ route('users.rates',$info->id) }}">
          <div class="modal-body">
            <div class="form-group">
                <label class="control-label col-lg-2">التقيم</label>
                <div class="col-lg-10">
                    <select name="rate" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <br/>
            {{ csrf_field() }}
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info">حفظ</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
          </div>
      </form>
    </div>

  </div>
</div>
@stop
