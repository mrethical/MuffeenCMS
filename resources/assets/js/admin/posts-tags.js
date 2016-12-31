
function refreshTable(html) {
    $('div#table-container').empty();
    $('div#table-container').append(html);
}

function reloadTable() {
    var success = function (result) {
        refreshTable(result);
        generatePagination();
    }
    callback('GET', 'admin/posts/tags', 'html', {output: 'table'}, success);
}

function generatePagination() {
    var count = $('input#total-record').val();
    var limit = 10;
    $('.pagination').pagination({
        items: count,
        itemsOnPage: limit,
        onPageClick: function(pageNumber){
            $('.pagination').pagination('disable');
            var success = function(result){
                refreshTable(result);
                $('.pagination').pagination('enable');
            }
            callback('GET', 'admin/posts/tags', 'html', {output: 'table', limit: limit, offset: (pageNumber - 1) * limit }, success);
        }
    });
}

function resetErrors() {
    $('#modal-tag-form-name').removeClass('has-error');
    $('#modal-tag-form-name .help-block').remove();
}

var success = function(result){
    if (result.success){
        reloadTable();
        $('#modal-tag').modal('hide');
        $('#modal-tag-submit').prop('disabled', false);
    }
}

var error = function(response) {
    if (response.status === 422) {
        for (var key in response.responseJSON) {
            var value = response.responseJSON[key];
        }
        $('#modal-tag-form-' + key).addClass('has-error');
        $('#modal-tag-form-' + key).append('<p class="help-block">' + value + '</p>');
        $('#modal-tag-submit').prop('disabled', false);
    }
}

var prepForm = function() {
    $('#modal-tag-submit').prop('disabled', true);
    resetErrors();
}

$(function() {
    $('#modal-tag').on('show.bs.modal', function (event) {
        // load data
        var button = $(event.relatedTarget);
        var action = button.data('action');
        var id = button.data('id') || 0;
        var name = button.data('name');
        // set data
        $('#modal-tag-label').text(action);
        $('#tag-id').val(id);
        $('#tag-name').val(name);
        // if submit add new
        if (action == 'Add New') {
            $('#modal-tag-submit').click(function() {
                prepForm();
                var data = { name: $('#tag-name').val(), _token: $('input#tag-post-token').val() };
                callback('POST', 'admin/posts/tags', 'json', data, success, error);
            });
        }
        // if submit edit
        else if (action == 'Edit') {
            $('#modal-tag-submit').click(function() {
                prepForm();
                var data = {
                    name: $('#tag-name').val(),
                    _token: $('input#tag-post-token').val(),
                    _method: 'PATCH'
                };
                callback('POST', 'admin/posts/tags/' + $('#tag-id').val(), 'json', data, success, error);
            });
        }
    });
    $('#modal-tag').on('hide.bs.modal', function (event) {
        $('#modal-tag-submit').unbind('click');
        resetErrors();
    });
    $('#modal-tag-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $('#modal-tag-delete-submit').click(function() {
            $('#modal-tag-delete').modal('hide');
            var data = {
                _token: $('input#tag-post-token').val(),
                _method: 'DELETE'
            };
            var success = function(result){
                if (result.success = true){
                    reloadTable();
                }
            }
            callback('POST', 'admin/posts/tags/' + id, 'json', data, success);
        });
    })

    generatePagination();

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

});