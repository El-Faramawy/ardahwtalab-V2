@extends('site.index') 
@section('title') الأقسام@stop 
@section('page')
<div class="our_products">
    <h1 class="pagetitle text-center">الأقسام</h1>
    <div class="products">
        @foreach(layout_data()->depts as $dp)
        <div class="prods">
            <a href="{{ $dp->link }}">
                <div class="pr_photo">
                    <img src="{{ $dp->image }}" alt="product">
                </div>
                <span class="pr_name">{{ $dp->name }}</span>
            </a>
        </div>
        @endforeach
    </div>
</div>
@stop