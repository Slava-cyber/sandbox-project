function validate(data, form) {
    if (data.status == true) {
        const element = document.getElementById(form.form);
        element.submit();
    } else {
        removeClass(form);
        for (field in form.data)
        {
            if (field != 'sex')
            {
                if (data.error[field] != null)
                {
                    setErrorFor(field, data.error[field]);
                } else
                {
                    if (form.form != 'login')
                    {
                        setSuccessFor(field);
                    }
                }
            }
        }
    }
}

function setErrorFor(input, message) {
    let element = document.getElementById(input);
    let formControl = element.parentElement;
    let small = formControl.querySelector('small');
    element.classList.add("is-invalid");
    small.classList.add("error");
    small.innerHTML = message;
}

function setSuccessForAll(input) {
    for (field in input.data) {
        if (field != 'sex') {
            let element = document.getElementById(field);
            element.classList.add("is-valid");
            element.classList.remove("is-invalid");
            let formControl = element.parentElement;
            let small = formControl.querySelector('small');
            small.classList.add("none");
            small.classList.remove("error");
        }
    }
}


function removeClass(data) {
    for (field in data.data) {
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

function setErrorFor(input, message) {
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