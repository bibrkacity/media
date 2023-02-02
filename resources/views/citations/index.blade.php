@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="/css/pages/index.css" />
@endsection

@section('content')

<input type="button" value="Add citate" onclick="location.href='{{ route('citations.create') }}'" />

@if( $data['error'] != '')
    <h2 class="error">{{ $data['error'] }}</h2>
@elseif(  count($data['citations'] ) == 0  )
    <h2>There is no citations yet</h2>
@else

    <h2>Citations ({{ count($data['citations']) }})</h2>
    <table>
        <tr>
            <th>Who has added citation</th>
            <th>Citation</th>
            <th>Created at</th>
            <th>Edit</th>
            <th>Share</th>
        </tr>

    @foreach( $data['citations'] as $citation )
            <tr>
                <td>{{ $citation->User->name }}</td>
                <td>{{ $citation->citation }}</td>
                <td>{{ $citation->created_at }}</td>
                <td><input type="button" value="Edit" onclick="location.href='{{ route('citations.edit',['id'=>$citation->id]) }}'" /></td>
                <td></td>
            </tr>
    @endforeach
    </table>

    {{ $data['links'] }}

@endif
@endsection
