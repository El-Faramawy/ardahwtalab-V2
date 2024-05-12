@extends('site.index')
@section('title') ط£ظ†ط¸ظ…ط© ط§ظ„ط§ط´طھط±ط§ظƒ @stop
@section('page')
<div id="content" class="col-md-12 nopadding"> 
	<div id="box-contents">
		<h1 class="box-contents-name">
			ط£ظ†ط¸ظ…ط© ط§ظ„ط¥ط´طھط±ط§ظƒط§طھ
		</h1>
		<div class="box-contents-content">
			<p class="bg-primary">
				<a ajax_open="true" href="{{ route('banking') }}">ظ„ظ„ط¥ط·ظ„ط§ط¹ ط¹ظ„ظ‰ ط·ظڈط±ظ‚ ط§ظ„ط³ط¯ط§ط¯ ط£ط¶ط؛ط· ظ‡ظ†ط§ </a>
			</p>
			<div id="box-elements">
				@foreach($jointypes as $info)
				<?php $rules=explode(',', $info->rules); ?>
				<div class="box-elements-item">
					<div class="box-elements-item-name">{{ $info->name }} <span> - {{ $info->price }} ط±ظٹط§ظ„ </span></div>
					<ul class="elements">
						@foreach($rules as $rl)
							<li> <i class="fa fa-check-circle"></i> {{ joinRules()[$rl] }}</li>
						@endforeach
					</ul>
					<a href="{{ route('joins.request',$info->name) }}" ajax_open="true" class="box-elements-item-request">ط£ط´طھط±ظƒ ط§ظ„ط¢ظ† </a>
				</div>
				@endforeach
			</div>

		</div>
		<div class="clear"></div> 
	</div>
	<div class="shadow"></div> 
</div>
@stop