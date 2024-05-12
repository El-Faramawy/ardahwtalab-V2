
  <?php $side_depts=\App\Models\Depts::all();dd($side_depts); ?>
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <!--close btn-->
   <span class="visible-xs" onclick="closeNav()"><i class="fa fa-close"></i></span>
    <!--close btn-->
   @foreach($side_depts as $dp)
    <?php $childs=$dp->props()->where('parent',null)->first(); ?>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
        <a href="{{ (!$childs) ? $dp->link :  '#collapseOne'.$dp->id }}" @if($childs) role="button" data-toggle="collapse" data-parent="#accordion" aria-expanded="false" aria-controls="collapseOne{{$dp->id}}" @endif>
          {{ $dp->name }}
        </a>
      </h4>
      </div>
      <div id="collapseOne{{ $dp->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <!--***********************************************************-->

            @if($childs)

            @foreach($childs->types as $ch)
            <div class="panel panel-default">
              <div class="panel-heading custom" role="tab" id="headingNine">
                <h4 class="panel-title">
                <a href="{{ (!count($ch->childs)) ? $ch->link : '#collapse'.$ch->id }}" @if(count($ch->childs)) role="button" data-toggle="collapse" data-parent="#accordion1" aria-expanded="false" aria-controls="collapse{{$ch->id}}" @endif>
                   {{ $ch->name }}
                </a>
              </h4>
              </div>
              @if($chids = $ch->childs)
              <div id="collapse{{$ch->id}}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingNine">
                <div class="panel-body">
                    <ul class="panel-list">
                    	@foreach($chids as $cd)
                        <li><a href="{{ $ch->link }}">{{ $cd->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
              </div>
              @endif
            </div>
            @endforeach
            @endif


        </div>
      </div>
    </div>
   @endforeach

  </div>
