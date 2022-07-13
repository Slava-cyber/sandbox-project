var acceptRequest = [];
var rejectRequest = [];
for (var i = 0; i < 3; i++) {
    acceptRequest[i] = document.getElementById('accept' + i);
    rejectRequest[i] = document.getElementById('reject' + i)
    if (acceptRequest[i] != null) {
        acceptRequest[i].addEventListener('click', acceptRequestFunction(i), false);
    }
    if (rejectRequest[i] != null) {
        rejectRequest[i].addEventListener('click', rejectRequestFunction(i), false);
    }
}

function sendXMLHttpRequest(i, type) {
    let requestId = document.getElementById('requestId' + i);
    var formData = new FormData();

    let data = {
        'data': {
            'id': requestId.value.trim(),
        },
        'type': type,
    };

    var json_arr = JSON.stringify(data);
    formData.append("all", json_arr);

    let request = new XMLHttpRequest();
    let url = '/sendRequest';
    request.open("POST", url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
        }
    };

    request.send(formData);
}


function acceptRequestFunction(i) {
    return function (event) {
        event.preventDefault();
        requestStatus = document.getElementById('requestStatus' + i);
        requestStatusChange = document.getElementById('requestStatusChange' + i);
        requestStatusDiv = document.getElementById('requestStatusDiv' + i);
        requestStatusDiv.classList.add("text-success");
        requestStatusDiv.classList.remove("text-danger");
        requestStatusChange.classList.remove("none");
        requestStatus.classList.add("none");
        requestStatusChange.innerHTML = 'Запрос принят';
        sendXMLHttpRequest(i, 'accept');
    };
}

function rejectRequestFunction(i) {
    return function (event) {
        event.preventDefault();
        requestStatus = document.getElementById('requestStatus' + i);
        requestStatusChange = document.getElementById('requestStatusChange' + i);
        requestStatusDiv = document.getElementById('requestStatusDiv' + i);
        requestStatusDiv.classList.add("text-danger");
        requestStatusDiv.classList.remove("text-success");
        requestStatusChange.classList.remove("none");
        requestStatus.classList.add("none");
        requestStatusChange.innerHTML= 'Запрос отклонен';
        sendXMLHttpRequest(i, 'reject');
    };
}
