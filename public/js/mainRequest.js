var outRequest = [];
for (var i = 0; i < 3; i++) {
    outRequest[i] = document.getElementById('outRequest' + i);
    if (outRequest[i] != null) {
        outRequest[i].addEventListener('click', sendRequest(i), false);
    }
}

function sendRequest(i) {
    return function (event) {
        event.preventDefault();
        outRequestDiv = document.getElementById('outRequestDiv' + i);
        statusRequestDiv = document.getElementById('statusRequestDiv' + i);
        outRequestDiv.classList.add("none");
        statusRequestDiv.classList.remove("none");

        let eventId = document.getElementById('eventId' + i);
        let userId = document.getElementById('userId' + i);
        let eventAuthor = document.getElementById('eventAuthor' + i);
        var formData = new FormData();

        let data = {
            'data': {
                'user': userId.value.trim(),
                'author': eventAuthor.value.trim(),
                'event': eventId.value.trim(),
            },
            'type': 'create',
        };

        var json_arr = JSON.stringify(data);
        formData.append("all", json_arr);

        let request = new XMLHttpRequest();
        let url = '/sendRequest';
        request.open("POST", url, true);
        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                console.log(request.response);
                let jsonData = JSON.parse(request.response);
            }
        };

        request.send(formData);
    };
}