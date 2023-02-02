@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="/css/pages/login.css" />
@endsection

@section('content')
    <form id="login" method="post" action="{{ route('login.submit') }}">
        {!! csrf_field() !!}
    <h3>Please login</h3>

        @foreach ($errors->all() as $error)

            <p class="error">{{ $error }}</p>

        @endforeach

    <div id="form">
        <div>
            <div>Email</div>
            <div><input type="email" name="email" required="required" /></div>
        </div>
        <div>
            <div>Password</div>
            <div><input type="password" name="password" required="required" /></div>
        </div>

        <div>
            <div></div>
            <div><input type="submit" value="Login" /></div>
        </div>
    </div>

        <p>No account? Please <a href="{{ route('registration') }}">register</a></p>

    </form>
@endsection
