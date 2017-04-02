
/*
 *  Jquery Toast Wrapper
 *
 */

class JqueryToast {

    static show(message, heading = '', icon = '') {
        console.log(message);
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
    console.log(message);
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

function redirectUnauthorized(response) {
    if (response.status === 403) {
        window.location.replace(server_url + '/login?unauthorized=1');
    }
}

function showErrorAlert(response) {
    if (response.status === 500) {
        toastError('An error has occurred. Please refresh the page.');
    }
}