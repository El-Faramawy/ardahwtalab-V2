@extends('site.index')
@section('title') {{ $page->title }} @stop
@section('page')
<div class="pageDiv container">
    <h1 class="pagetitle">{{ $page->title }}</h1>
    {!!html_entity_decode($page->content)!!}
</div>
@stop