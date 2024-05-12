@extends('site.index')
@section('title') بيانات المحامى@stop
@section('page')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <p class="form-h"> بيانات المحامى</p>
        <table class="table table-responsive table-bordered">
            <tr>
                <th>الاسم</th>
                <td>{{ $info->fullname }}</td>
            </tr>
            <tr>
                <th>البريد الإلكترونى</th>
                <td>{{ $info->email }}</td>
            </tr>
            <tr>
                <th>أرقام التواصل</th>
                <td>
                    @foreach($info->phones as $phone)
                    <li><a href="tel:{{ $phone }}">{{ $phone }}</a></li>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>العنوان</th>
                <td>{{ $info->address }}</td>
            </tr>
            <tr>
                <th>نبذة مختصرة</th>
                <td>{{ $info->brief }}</td>
            </tr>

        </table>
    </div>
</div>
@stop