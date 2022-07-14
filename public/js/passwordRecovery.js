let actionButton = document.getElementById('action');

actionButton.addEventListener('click', function (event) {
    let login = document.getElementById('loginField');
    let email = document.getElementById('emailField');
    console.log(login);
    console.log(email);
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
            let jsonData = JSON.parse(request.response);
            console.log(jsonData);
        }
    };

    request.send(formData);
    //passwordRecoveryForm.submit();
});
