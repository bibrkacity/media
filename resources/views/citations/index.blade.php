@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="/css/pages/index.css" />
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="/js/citations.js"></script>
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
            <th>Shared</th>
            <th>Share</th>
        </tr>

    @foreach( $data['citations'] as $citation )
            <tr>
                <td>{{ $citation->User->name }}</td>
                <td>{{ $citation->citation }}</td>
                <td>{{ $citation->created_at }}</td>
                <td><input type="button" value="Edit" onclick="location.href='{{ route('citations.edit',['id'=>$citation->id]) }}'" /></td>
                <td>
                @if( $citation->Messengers )
                    {{ count($citation->Messengers) }}
                @else
                   Don't yet
                @endif
                    </td>
                <td><div class="share">
                        <input type="button" value="Поділитися" onclick="this.nextElementSibling.classList.toggle('show')" />
                        <div class="share_form">
                            {!! \App\Services\CitationService::send_form($citation->id, $data['messengers']) !!}
                        </div>
                    </div>
                </td>
            </tr>
    @endforeach
    </table>

    {{ $data['links'] }}

@endif
@endsection
