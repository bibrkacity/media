async function fields(name, citation_id) {
    let html = '';
    if (name != '') {
        let url = '/citations/ajax/send/fields?name='+name;
        let response = await fetch(url);

        if (response.ok) {
            html = await response.text();
        } else {
            alert("Ошибка HTTP: " + response.status);
        }

        console.log(html);

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

}
