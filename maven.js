console.log("dero waa")
const form = document.querySelector('form');
form.addEventListener('submit', handleSubmit);

function handleSubmit(event) {
    event.preventDefault();
}

function handleSubmit(event) {
    event.preventDefault();

    uploadFiles();
}

function uploadFiles() {
    const url = 'https://upload.mwonya.com/process-upload';
    const formData = new FormData(form);

    const fetchOptions = {
        method: 'post',
        body: formData,
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': 'Origin, X-Requested-With, Content-Type, Accept',
            'Access-Control-Allow-Credentials': 'true',
        },
    };

    fetch(url, fetchOptions);
}