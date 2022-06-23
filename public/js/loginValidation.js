const loginForm = document.getElementById('login');

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let login = document.getElementById("login_sign_in");
        let psw = document.getElementById("password");
    console.log(14);
        let request = new XMLHttpRequest();
        let url = '/validation';
        request.open("POST", url, true);
        request.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                let jsonData = JSON.parse(request.responseText);
                validate(jsonData, data);
            }
        };

        let data = {
            'form': 'login',
            'data':
                {
                    'login_sign_in': login.value.trim(),
                    'password': psw.value.trim(),
                },
        };
        request.send(JSON.stringify(data));
    });

/*function removeClass(data) {
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
}*/