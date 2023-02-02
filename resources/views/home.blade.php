@extends('layouts.app')

@section('css')
    @parent
@endsection

@section('content')

    <h1>Homepage</h1>

    <p><a href="{{ route('citations.index') }}">Citates</a></p>

@endsection
