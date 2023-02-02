@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="/css/pages/reg.css" />
@endsection

@section('content')
    <form id="login" method="post" action="{{ route('registration.submit') }}">
        {!! csrf_field() !!}
    <h3>Please register</h3>

        @foreach ($errors->all() as $error)

            <p class="error">{{ $error }}</p>

        @endforeach

    <div id="form">
        <div>
            <div>Name</div>
            <div><input type="text" name="name" required="required" /></div>
        </div>
        <div>
            <div>Email</div>
            <div><input type="email" name="email" required="required" /></div>
        </div>
        <div>
            <div>Password</div>
            <div><input type="password" name="password" required="required" /></div>
        </div>
        <div>
            <div>Confirm password</div>
            <div><input type="password" name="password_confirmation" required="required" /></div>
        </div>
        <div>
            <div></div>
            <div><input type="submit" value="Registration" /></div>
        </div>
    </div>

    </form>
@endsection
