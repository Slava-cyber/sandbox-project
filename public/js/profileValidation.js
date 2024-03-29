const profileForm = document.getElementById('profile');
let avatar = document.getElementById("avatar");

avatar.addEventListener('change', function(event) {

    file = avatar.files[0];
    console.log(file);
    var formData = new FormData();
    let data = {
        'form' : 'image',
    };
    var json_arr = JSON.stringify(data);
    formData.append("all", json_arr);
    formData.append("userfile", file);

    let request = new XMLHttpRequest();
    let url = '/validation';
    request.open("POST", url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let jsonData = JSON.parse(request.response);
            image_validate(jsonData);
        }
    };

    request.send(formData);
});

profileForm.addEventListener("submit", function(event) {
    event.preventDefault();
    var formData = new FormData();

    let pathImage = document.getElementById("path_image")
    let name =  document.getElementById("name");
    let surname =  document.getElementById("surname");
    let dateOfBirth =  document.getElementById("date_of_birth");
    let town =  document.getElementById("town");
    let phoneNumber =  document.getElementById("phone_number");
    let interest =  document.getElementById("interest");
    let description =  document.getElementById("description");
    let avatar = document.getElementById("avatar");

    let data = {
        'form' : 'profile',
        'data' :
            {
                'file': "default",
                'path_image' :pathImage.value.trim(),
                'name' : name.value.trim(),
                'surname' : surname.value.trim(),
                'date_of_birth' : dateOfBirth.value.trim(),
                'town' : town.value.trim(),
                'phone_number' : phoneNumber.value.trim(),
                'interest' : interest.value.trim(),
                'description' : description.value.trim(),
            },
    };
    var json_arr = JSON.stringify(data);
    formData.append('all', json_arr);

    let requestForm = new XMLHttpRequest();
    let url = '/validation';
    requestForm.open("POST", url, true);
    requestForm.onreadystatechange = function () {
        if (requestForm.readyState === 4 && requestForm.status === 200) {
            let jsonData = JSON.parse(requestForm.response);
            validate(jsonData, data);
        }
    };

    requestForm.send(formData);
});