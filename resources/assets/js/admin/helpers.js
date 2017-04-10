
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
        data.stack = 4;
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
 *  Time Formatter
 *
 */

function timestamp(timestamp)
{
    let miliseconds = new Date(timestamp.replace(' ', 'T')).getTime();
    let seconds = miliseconds / 1000;
    let seconds_now = Date.now() / 1000;
    let difference = seconds_now - seconds;
    if (difference < 11) return 'Just Now';
    else if (difference < 60) return Math.floor(difference) + ' seconds ago';
    else if (difference < 120) return '1 minute ago';
    else if (difference < 3600) return Math.floor(difference/60) + ' minutes ago';
    else if (difference < 7200) return '1 hour ago';
    else if (difference < 86400) return Math.floor(difference/3600) + ' hours ago';
    else if (difference < 172000) return 'Yesterday';
    else return miliseconds.format("mm/dd/yyyy");
}

function date(timestamp)
{
    let miliseconds = new Date(timestamp.replace(' ', 'T')).getTime();
    return moment(miliseconds).format("MM/DD/YYYY");
}

/*
 *  Bits Formatter
 *
 */

function format_bytes(bytes, format, precision = 2) {
    let list_units = ['B', 'KB', 'MB', 'GB', 'TB'];
    let index = list_units.findIndex((element) => { return element === format });
    let units = [];
    if (index)
    {
        for(let i = 0; i < list_units.length; i++)
        {
            units.push(list_units[i]);
        }
    }

    bytes = Math.max(bytes, 0);
    let pow = Math.floor((bytes ? Math.log(bytes) : 0) / Math.log(1024));
    pow = Math.min(pow, units.length - 1);

    bytes /= Math.pow(1024, pow);

    return Math.round(bytes, precision) + ' ' + units[pow];
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

function removeValidationAlerts() {
    $('.alert.validation').remove();
}

function redirectUnauthorized(response) {
    if (response.status === 403) {
        window.location.replace(server_url + '/login?unauthorized=1');
    }
}

function showErrorToast() {
    toastError('An error has occurred. Please refresh the page.');
}

function copyToClipboard(text, success = 'Copy to clipboard successful.') {
    if (window.clipboardData && window.clipboardData.setData) {
        return clipboardData.setData('Text', text);
    } else if (document.queryCommandSupported && document.queryCommandSupported('copy')) {
        let textarea = document.createElement('textarea');
        textarea.textContent = text;
        textarea.style.position = 'fixed';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            toastSuccess(success);
        } catch (ex) {
            toastError('Copy to clipboard failed.');
            return false;
        } finally {
            document.body.removeChild(textarea);
        }
    }
}