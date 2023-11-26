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
            'Access-Control-Allow-Origin': 'https://artist.mwonya.com',
            'Access-Control-Allow-Methods': 'POST',
            'Access-Control-Allow-Headers': 'DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type',
            'Access-Control-Allow-Credentials': 'true',
        },
    };

    fetch(url, fetchOptions);
}