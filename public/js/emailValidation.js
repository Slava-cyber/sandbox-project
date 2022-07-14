emailForm = document.getElementById('emailForm');

emailForm.addEventListener("submit", function (event) {
    event.preventDefault();
    let email = document.getElementById("email");
    var formData = new FormData();
    let data = {
        'form': 'emailForm',
        'data':
            {
                'email': email.value.trim(),
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