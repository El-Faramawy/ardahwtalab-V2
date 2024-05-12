@extends('site.index')
@section('title') {{ $title }} @stop
@section('page')
	@if(isset($advs))
		@include('site.advs.list')
	@elseif(isset($info))
		@include('site.advs.info')
	@endif
@stop