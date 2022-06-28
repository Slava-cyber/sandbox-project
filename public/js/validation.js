function validate(data, form) {
    const formControl = document.getElementById(form.form);
    let php_error = document.getElementById('php_error');
    if (data.status == true) {
        console.log(data.status);
        formControl.submit();
    } else {
        removeClass(form);
        if (php_error != null)
        {
            php_error.classList.add("none");
        }
        for (field in form.data)
        {
            if (field != 'sex' && field != 'path_image' && field != 'file')
            {
                if (data.error[field] != null)
                {
                    setErrorFor(field, data.error[field]);
                } else
                {
                    setSuccessFor(field, form.form);
                }
            }
        }
    }
}

function image_validate(data) {
    const avatar = document.getElementById('avatar');
    const hidden = document.getElementById('path_image');
    let formControl = avatar.parentElement;
    let small = formControl.querySelector('small');
    if (data.status == true) {
        const image = document.getElementById('image');
        console.log(data.error['avatar']);
        image.src=data.error['avatar'];
        hidden.value=data.error['avatar'];
        small.classList.add("none");
        small.classList.remove("error");
    } else {
        small.classList.add("error");
        small.classList.remove("none");
        avatar.value="";
        hidden.value="";
        small.innerHTML = data.error['avatar'];
    }
}

/*function setErrorFor(input, message) {
    let element = document.getElementById(input);
    let formControl = element.parentElement;
    let small = formControl.querySelector('small');
    element.classList.add("is-invalid");
    small.classList.add("error");
    small.innerHTML = message;
}*/

/*function setSuccessForAll(input) {
    for (field in input.data) {
       // if (field != 'sex'  && field != 'path_image' && field != 'file')  {
            let element = document.getElementById(field);
            element.classList.add("is-valid");
            element.classList.remove("is-invalid");
            let formControl = element.parentElement;
            let small = formControl.querySelector('small');
            small.classList.add("none");
            small.classList.remove("error");
       // }
    }
}*/

function removeClass(data) {
    for (field in data.data) {
        console.log(field);
        if (field != 'sex'  && field != 'path_image' && field != 'file') {
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

function setSuccessFor(input, form) {
    let element = document.getElementById(input);
    if (form != 'login')
    {
        element.classList.add("is-valid");
    }
    let formControl = element.parentElement;
    let small = formControl.querySelector('small');
    small.classList.add("none");
}