const mainForm = document.getElementById('search');

var inputPage = [];
var liPage = [];
for (var i = 0; i < 6; i++) {
    inputPage[i] = document.getElementById('inputPage' + i);
    liPage[i] = document.getElementById('liPage' + i);
    if (inputPage[i] != null) {
        liPage[i].addEventListener('click', sendForm(inputPage[i], mainForm), false);
    }
}
console.log(inputPage);

function sendForm(element, form) {
    return function (event) {
        event.preventDefault();
        form.action = element.value;
        form.submit();
    };
}

