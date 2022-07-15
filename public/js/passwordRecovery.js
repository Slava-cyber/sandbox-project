let actionButton = document.getElementById('action');

actionButton.addEventListener('click', function (event) {
    let login = document.getElementById('loginField');
    let email = document.getElementById('emailField');
    var formData = new FormData();

    let data = {
        'data': {
            'login': login.value.trim(),
            'email': email.value.trim(),
        },
    };

    var json_arr = JSON.stringify(data);
    formData.append("all", json_arr);

    let request = new XMLHttpRequest();
    let url = '/passwordRecovery';
    request.open("POST", url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            console.log(request.response);
            let jsonData = JSON.parse(request.response);
            responseProcessing(jsonData);
        }
    };

    request.send(formData);
});

function responseProcessing(data) {
    let beforeSend = document.getElementById('beforeSend');
    if (data != 'success' && data != 'error') {
        let smallError = document.getElementById('error');
        smallError.classList.remove('none');
        smallError.classList.add('error');
        smallError.innerHTML = data;
    } else {
        let action = document.getElementById('action');
        action.classList.add('none');
        let label = document.getElementById('label');
        label.classList.add('none');
        let beforeSend = document.getElementById('beforeSend');
        beforeSend.classList.add('none');
        if (data == 'success') {
            let success = document.getElementById('success');
            success.classList.remove('none');
        } else {
            let fail = document.getElementById('fail');
            fail.classList.remove('none');
        }
    }
}