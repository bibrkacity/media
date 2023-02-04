<form id="f{{ $citation_id  }}">

    <input type="hidden" name="$citation_id" value="{{ $citation_id }}">

    <div><label for="messenger_id">Messenger</label></div>
    <div>
        <select name="messenger_id" onchange="fields(this.value, {{ $citation_id  }})">
            @foreach($messengers as $messenger)
                <option value="{{ $messenger[0] }}">{{ $messenger[1] }}</option>
            @endforeach
        </select>
    </div>



</form>
