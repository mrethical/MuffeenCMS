
function redirectUnauthorized(response) {
    if (response.status === 403) {
        window.location.replace(server_url + '/login?unauthorized=1');
    }
}

function showErrorAlert(response, element) {
    if (response.status === 500) {
        element.prepend($(`
        <div id="error-alert" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <p>An error has occurred. Please refresh the page.</p>
        </div>`
        ));
    }
}