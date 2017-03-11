
function refreshTable(html) {
    $('div#table-container').empty();
    $('div#table-container').append(html);
}

function reloadTable() {
    var success = function (result) {
        refreshTable(result);
        generatePagination();
    }
    callback('GET', 'admin/resources/categories', 'html', {output: 'table'}, success);
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
            callback('GET', 'admin/resources/categories', 'html', {output: 'table', limit: limit, offset: (pageNumber - 1) * limit }, success);
        }
    });
}

function resetErrors() {
    $('#modal-category-form-name').removeClass('has-error');
    $('#modal-category-form-name .help-block').remove();
}

var success = function(result){
    if (result.success){
        reloadTable();
        $('#modal-category').modal('hide');
        $('#modal-category-submit').prop('disabled', false);
    }
}

var error = function(response) {
    if (response.status === 422) {
        for (var key in response.responseJSON) {
            var value = response.responseJSON[key];
        }
        $('#modal-category-form-' + key).addClass('has-error');
        $('#modal-category-form-' + key).append('<p class="help-block">' + value + '</p>');
        $('#modal-category-submit').prop('disabled', false);
    }
}

var prepForm = function() {
    $('#modal-category-submit').prop('disabled', true);
    resetErrors();
}

$(function() {
    $('#modal-category').on('show.bs.modal', function (event) {
        // load data
        var button = $(event.relatedTarget);
        var action = button.data('action');
        var id = button.data('id') || 0;
        var name = button.data('name');
        // set data
        $('#modal-category-label').text(action);
        $('#category-id').val(id);
        $('#category-name').val(name);
        // if submit add new
        if (action == 'Add New') {
            $('#modal-category-submit').click(function() {
                prepForm();
                var data = { name: $('#category-name').val(), _token: $('input#category-resource-token').val() };
                callback('POST', 'admin/resources/categories', 'json', data, success, error);
            });
        }
        // if submit edit
        else if (action == 'Edit') {
            $('#modal-category-submit').click(function() {
                prepForm();
                var data = {
                    name: $('#category-name').val(),
                    _token: $('input#category-resource-token').val(),
                    _method: 'PATCH'
                };
                callback('POST', 'admin/resources/categories/' + $('#category-id').val(), 'json', data, success, error);
            });
        }
    });
    $('#modal-category').on('hide.bs.modal', function (event) {
        $('#modal-category-submit').unbind('click');
        resetErrors();
    });
    $('#modal-category-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $('#modal-category-delete-submit').click(function() {
            $('#modal-category-delete').modal('hide');
            var data = {
                _token: $('input#category-resource-token').val(),
                _method: 'DELETE'
            };
            var success = function(result){
                if (result.success){
                    reloadTable();
                }
            }
            callback('POST', 'admin/resources/categories/' + id, 'json', data, success);
        });
    })

    generatePagination();

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

});
