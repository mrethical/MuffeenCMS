
/*
 *  Jquery Toast Wrapper
 *
 */

class JqueryToast {

    static show(message, heading = '', icon = '') {
        let data = {};
        data.showHideTransition = 'plain';
        data.position = {
            right: 10,
            top: 60
        };
        data.text = message;
        data.heading = heading;
        data.icon = icon;
        $.toast(data);
    }

}

function toastSuccess(message, heading = 'Success') {
    JqueryToast.show(message, heading, 'success');
}

function toastInformation(message, heading = 'Information') {
    JqueryToast.show(message, heading, 'info');
}

function toastWarning(message, heading = 'Warning') {
    JqueryToast.show(message, heading, 'warning');
}

function toastError(message, heading = 'Error') {
    JqueryToast.show(message, heading, 'error');
}



/*
 *  Misc
 *
 */

function listValidationErrors(errors) {
    let html = '<ul>';
    for (let key in errors) {
        errors[key].forEach((value) => {
            html += `<li>${value}</li>`;
        })
    }
    return html + '</ul>';
}

function showValidationAlert(response, element) {
    if (response.status === 422) {
        element.prepend($(`
            <div class="alert alert-danger alert-dismissible validation">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                ${listValidationErrors(response.responseJSON)}
              </div>
        `));
    }
}

function redirectUnauthorized(response) {
    if (response.status === 403) {
        window.location.replace(server_url + '/login?unauthorized=1');
    }
}

function showErrorToast() {
    toastError('An error has occurred. Please refresh the page.');
}