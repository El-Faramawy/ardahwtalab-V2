@extends('site.index')

@section('title') تفعيل حسابك @stop

<!-- Main Content -->

@section('page')

<div class="container">

    <div class="row">

        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="panel panel-default">

                <div class="panel-heading">تفعيل حسابك</div>

                <div class="panel-body">

                    @if (session('true'))

                        <div class="alert alert-success">

                            {{ session('true') }}

                        </div>

                    @endif



                    @if (session('error'))

                        <div class="alert alert-warning">

                            {{ session('error') }}

                        </div>

                    @endif



                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.active') }}">

                        {{ csrf_field() }}



                        <div class="form-group">

                            <label for="email" class="col-md-12">البريد الإلكترونى</label>



                            <div class="col-md-12">

                                <input id="email" type="email" placeholder="البريد الإلكترونى" class="form-control" name="email" @if(Auth::check()) value="{{Auth::user()->email}}" @endif>

                            </div>

                        </div>

                        {{ csrf_field() }}

                        <div class="form-group">

                            <div class="col-md-12 col-md-offset-4">

                                <button type="submit" class="btn btn-primary">

                                    <i class="fa fa-btn fa-envelope"></i>إرسال لينك التفعيل

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

