//const form = document.querySelector( '[name="registration"]' );
//form.addEventListener( 'submit', validate );
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let nameField = document.getElementById('name');
        console.log(nameField);

    }
});

/*$('.btn').click(function(event) {
    event.preventDefault();

    $(`input`).removeClass('error');

    let login = $(`input[name="login"]`).val(),
        password = $(`input[name="password"]`).val();

    $.ajax({
        url: 'src/signin.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password
        },
        success(data) {

            if (data.status) {
                if (data.admin_status) {
                    document.location.href = '/profile.php';
                } else {
                    document.location.href = '/user_profile.php'
                }
            } else {
                if (data.type == 1) {
                    data.fields.forEach(function(field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.msg').removeClass('none').text(data.message);
            }
        }
    });
});*/

/*function check_name(name) {
    var res = 0;
    var letters = /^[A-Za-z]+$/;
    if (!name.value.trim().match(letters)) {
        res += 1;
        var text = 'Должны быть только буквы';
        var error = error_create(text);
        name.parentElement.insertBefore(error, name.nextSibling);
    }
    return res;
}
function check_login(login) {
    var res = 0;
    var letters = /^[_,0-9A-Za-z]+$/;
    if (!login.value.trim().match(letters)) {
        res += 1;
        var text = 'Логин может состоять из букв, цифр и "_"';
        var error = error_create(text);
        login.parentElement.insertBefore(error, login.nextSibling);
    }
    return res;
}

function check_date(date)
{
    var res = 0;
    var date = new Date(date.value);
    //var year = date.getFullYear();
    //var month = date.getMonth() + 1;
    //var day = date.getDate();
    //if ((year > 2022) || (year < 1920) || (month < 0) || (month > 12) || (day < 1) || (day > 31) {
    //    return true;
    //} else {
    //    alert("Введена некорректная дата!");
    //    return false;
    //}*/
   // return true;
  /*  if (isNaN(date))
    {
        res += 1;
    }
    return res;
}

function error_create (text) {
    var error = document.createElement('div');
    error.className = 'error';
    error.style.color = 'red';
    error.innerHTML = text;
    return error;
}


function validate(e) {
    const name =  document.querySelector( 'input[name="name"]' );
    const surname =  document.querySelector( '[name="surname"]' );
    const birth =  document.querySelector( '[name="birth_date"]' );
    const gender =  document.querySelector( '[name="gender"]' );
    const login =  document.querySelector( '[name="login"]' );
    const psw =  document.querySelector( '[name="password"]' );
    const confirm_psw =  document.querySelector( '[name="password_confirm"]' );
    //var valid = true;
    var valid = 0;
    valid += check_name(name);
    valid += check_name(surname);
    valid += check_login(login);
    valid += check_date(birth);
    // удаляем все уже существующие ошибки валидации, чтобы проверять по новой
    const errors = document.getElementsByClassName( 'error' );
    while( errors.length > 0 ){
        errors[0].parentNode.removeChild( errors[0] );
    }

    // проверяем автора
    /*const nameField = document.registration.name;

    if ( ! nameField.value ) { // если не заполнено
        document.querySelector( 'label[for="name"]' ).innerHTML += ' <span class="validation-error">Укажите имя</span>';
        valid = false;
    }

    // проверяем поле комментария
    const surnameField =  document.querySelector( 'input[name="surname"]' );

    if ( ! surnameField.value ) { // если не заполнено
        document.querySelector( 'label[for="surname"]' ).innerHTML += ' <span class="validation-error">А где ваш комментарий?</span>';
        valid = false;
    }
*/
    // проверяем поле емейла
    /*const emailField = document.getElementById( "email" );

    if ( ! emailField.value ) { // если не заполнено
        document.querySelector( 'label[for="email"]' ).innerHTML += ' <span class="validation-error">Укажите email</span>';
        valid = false;
    } else { // если заполнено, то проверяем на корректность email-адреса регулярным выражением
        const re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
        if( ! re.test(String(emailField.value).toLowerCase()) ) {
            document.querySelector( 'label[for="email"]' ).innerHTML += ' <span class="validation-error">Некорректный email</span>';
            valid = false;
        }
    }*/
    //console.log(valid);
   /* if( valid > 0) {
        valid = false;
       // e.preventDefault(); // предотвращаем отправку формы, если есть ошибки валидации
    }
    else
    {
        valid = true;
    }
    //e.preventDefault();
    console.log('check', check_date(birth));
    console.log(valid);
    console.log(name.value);
    //console.log(new Date(birth.value));
    console.log(check_name(name));

    return valid;
}
   */