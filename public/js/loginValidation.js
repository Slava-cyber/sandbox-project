const loginForm = document.getElementById('login');

if (sessionStorage.getItem("is_reloaded")) {
    let php_error = document.getElementById('php_error');
    php_error.classList.remove("none");
}

loginForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let login = document.getElementById("login_sign_in");
    let psw = document.getElementById("password");
    var formData = new FormData();
    let data = {
        'form': 'login',
        'data':
            {
                'login_sign_in': login.value.trim(),
                'password': psw.value.trim(),
            },
    };

    var json_arr = JSON.stringify(data);
    formData.append("all", json_arr);

    let request = new XMLHttpRequest();
    let url = '/validation';
    request.open("POST", url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let jsonData = JSON.parse(request.response);
            validate(jsonData, data);
        }
    };

    request.send(formData);
});
