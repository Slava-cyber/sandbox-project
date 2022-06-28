const registrationForm = document.getElementById('registration');

if (sessionStorage.getItem("is_reloaded")) {
    let php_error = document.getElementById('php_error');
    php_error.classList.remove("none");
}

registrationForm.addEventListener("submit", function(event) {
    event.preventDefault();
    let name =  document.getElementById("name");
    let surname =  document.getElementById("surname");
    let birthDate =  document.getElementById("date_of_birth");
    let sex =  document.getElementById("sex");
    let login =  document.getElementById("login_sign_up");
    let psw =  document.getElementById("password_sign_up");
    let pswConfirm = document.getElementById("password_confirm");

    var formData = new FormData();
    let data = {
        'form' : 'registration',
        'data' :
            {
                'name' : name.value.trim(),
                'surname' : surname.value.trim(),
                'date_of_birth' : birthDate.value.trim(),
                'sex' : sex.value.trim(),
                'login_sign_up' : login.value.trim(),
                'password_sign_up' : psw.value.trim(),
                'password_confirm' : pswConfirm.value.trim(),
            },
    };

    var json_arr = JSON.stringify(data);
    formData.append('all', json_arr);

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
