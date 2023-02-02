@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="/css/pages/create.css" />
@endsection

@section('content')

    <p><a href="{{ route('citations.index') }}">List of citations</a></p>

    <form id="create_or_edit" method="post" action="{{ route('citations.update',['id'=>$data['id']]) }}">
        @method('PUT')
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{ $data['id'] }}" />
        <h3>Edit citation</h3>

        @foreach ($errors->all() as $error)

            <p class="error">{{ $error }}</p>

        @endforeach

        <div id="form">
            <div>
                <div>Citation<br />(max 500 liters)</div>
                <div><textarea  name="citation" maxlength="500" rows="8" cols="50" required="required">{{ $data['citation'] }}</textarea></div>
            </div>


            <div>
                <div></div>
                <div><input type="submit" value="Save" /></div>
            </div>
        </div>

    </form>
@endsection
