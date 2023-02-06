<form id="f{{ $citation_id  }}">
    {!! csrf_field() !!}
    <input type="hidden" name="citation_id" value="{{ $citation_id }}">

    <div><label for="messenger_name">Messenger</label></div>
    <div>
        <select name="messenger_name" onchange="fields(this.value, {{ $citation_id  }})">
            @foreach($messengers as $messenger)
                <option value="{{ $messenger[0] }}">{{ $messenger[1] }}</option>
            @endforeach
        </select>
    </div>

</form>
