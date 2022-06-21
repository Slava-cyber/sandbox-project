const registrationForm = document.getElementById('registration');
const loginForm = document.getElementById('login');

loginForm.addEventListener("submit", function(event) {
    event.preventDefault();
    let login =  document.getElementById("login_sign_in");
    let psw =  document.getElementById("password");

    let request = new XMLHttpRequest();
    let url = '/validation';
    request.open("POST", url, true);
    request.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let jsonData = JSON.parse(request.responseText);
            validate(jsonData, loginForm);
        }
    };

    let data = {
        'form' : 'login',
        'data' :
            {
                'login_sign_in' : login.value.trim(),
                'password' : psw.value.trim(),
            },
    };
    request.send(JSON.stringify(data));
});

registrationForm.addEventListener("submit", function(event) {
    event.preventDefault();
    let name =  document.getElementById("name");
    let surname =  document.getElementById("surname");
    let birthDate =  document.getElementById("date_of_birth");
    let sex =  document.getElementById("sex");
    let login =  document.getElementById("login_sign_up");
    let psw =  document.getElementById("password_sign_up");
    let pswConfirm = document.getElementById("password_confirm");

    let request = new XMLHttpRequest();
    let url = '/validation';
    request.open("POST", url, true);
    request.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let jsonData = JSON.parse(request.responseText);
            validate(jsonData, registrationForm);
        }
    };

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
    request.send(JSON.stringify(data));
});

function removeClass(data) {
    for (field in data.error) {
        if (field != 'sex') {
            let element = document.getElementById(field);
            element.classList.remove('is-invalid');
            element.classList.remove('is-valid');
            let formControl = element.parentElement;
            let small = formControl.querySelector('small');
            small.classList.remove('none');
            small.classList.remove('error');
        }
    }
}

function validate(data, form) {
    removeClass(data);
    console.log(data.status);
    if (data.status == true) {
        console.log(data.status);
        form.submit();
    } else {
        for (field in data.error) {
            if (field != 'sex'){
                if (data.error[field] == '') {
                    setSuccessFor(field);
                } else {
                    setErrorFor(field, data.error[field]);
                }
            }
        }
    }
}

function setErrorFor(input, message) {
    console.log(input);
    let element = document.getElementById(input);
    let formControl = element.parentElement;
    let small = formControl.querySelector('small');
    element.classList.add("is-invalid");
    small.classList.add("error");
    small.innerHTML = message;
}

function setSuccessFor(input) {
    let element = document.getElementById(input);
    element.classList.add("is-valid");
    let formControl = element.parentElement;
    let small = formControl.querySelector('small');
    small.classList.add("none");
}