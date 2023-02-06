async function fields(name, citation_id) {
    let html = '';
    if (name != '') {
        let url = url_fields + '?name='+name; //url_fields declared in view citations.index line ~11
        let response = await fetch(url);

        if (response.ok) {
            html = await response.text();
        } else {
            alert("HTTP error: " + response.status);
        }

        if(html != ''){

            let div = document.getElementById('fields'+citation_id);

            if(!div){
                let form = document.getElementById('f'+citation_id);
                div = document.createElement('DIV');
                div.className = 'fields';
                div.id = 'fields'+citation_id;
                div = form.appendChild(div);
            }
            div.innerHTML=html + '<input type="button" value="Send" onclick="send('+citation_id+')" />';
        }
    }
}

function send(citation_id)
{

    let form = document.getElementById('f'+citation_id);

    let data = {};

    for(let i=0 ; i<form.elements.length; i++ ){
        data[form.elements[i].name] = form.elements[i].value;
    }

//url_fields declared in view citations.index line ~12
    let response = fetch(url_send, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(data)
    });

    send_finish(citation_id);

}

function send_finish(citation_id)
{
    let div = document.getElementById('fields'+citation_id);
    div.innerText = 'Citation was sent!';
    setTimeout( 'hide_form('+citation_id+')',1500);
}

function hide_form(citation_id)
{
    let div = document.getElementById('share_form' + citation_id);
    div.classList.toggle('show')
}
