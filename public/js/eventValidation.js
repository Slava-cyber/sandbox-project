const eventAddForm = document.getElementById('eventAdd');

eventAddForm.addEventListener('submit', function (event) {
    event.preventDefault();
    let title = document.getElementById('title');
    let town = document.getElementById('town');
    let datetime = document.getElementById('datetime');
    let category = document.getElementById('category');
    let description = document.getElementById('description');

    var formData = new FormData();
    let data = {
        'form': 'eventAdd',
        'data':
            {
                'title': title.value.trim(),
                'town': town.value.trim(),
                'datetime': datetime.value.trim(),
                'category': category.value.trim(),
                'description': description.value.trim(),
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