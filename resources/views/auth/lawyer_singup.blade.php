@extends('site.index')
@section('title') تسجيل بيانات محامى@stop
@section('page')
<div>
    <p class="form-h">تسجيل بيانات محامى</p>
    @include('validate')
    <form novalidate class="modal-form" method="post" action="{{ route('lawyer_signup') }}">
        <div class="form-group">
            <select name="category_id" class="form-control selectpicker" title="حدد القسم">
                @foreach($categories as $cat)
                <option {{ old('category_id') == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">{{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <input type="text" required class="form-control" placeholder="الاسم بالكامل" value="{{ old('fullname') }}"
            name="fullname">
        <input type="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required class="form-control"
            name="email">
        <input type="text" required class="form-control" placeholder="رقم التواصل" name="phones[]">
        <input type="text" value="{{ old('address') }}" required class="form-control" name="address"
            placeholder="العنوان">
        <textarea required class="form-control" name="brief" placeholder="نبذة مختصرة">{{ old('brief') }}</textarea>
        {{ csrf_field() }}
        <br>
        <button class="hvr-rectangle-in" type="submit">تسجيل البيانات</button>
    </form>
    <a class="side-link1" href="{{ route('lawyer_login') }}">لديك حساب بالفعل ؟</a>
</div>
@stop