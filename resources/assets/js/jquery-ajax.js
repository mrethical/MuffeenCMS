
function callback(method, location, dataType, data, success, error) {
    $.ajax({
        data: data,
        url: server_dir + location,
        dataType: dataType,
        method: method,
        success: function(result) {
            success(result);
        },
        failure: function() {
            console.log('failure');
        },
        error: function(response) {
            if (error) error(response);
        },
        xhr: function() {
            var xhr = $.ajaxSettings.xhr();
            xhr.onprogress = function(evt) {
                $("body").css("cursor", "wait");
            };
            xhr.onloadend = function(evt) {
                $("body").css("cursor", "default");
            };
            return xhr;
        }
    });
}