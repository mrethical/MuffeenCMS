
function generatePosts(result) {
    var html = '<option value="">NONE</option>';
    for(var key in result) {
        html += '<option value="' + key + '">' + result[key] + '</option>';
    }
    $('#menu-post').empty();
    $('#menu-post').append($(html));
}

function generateParentMenus(result) {
    var html = '<option value="">NONE</option>';
    for(var i = 0; i < result.length; i++) {
        html += '<option value="' + result[i].id + '">' + result[i].name + '</option>';
    }
    $('#menu-parent').empty();
    $('#menu-parent').append($(html));
}

function refreshTable(html) {
    $('div#table-container').empty();
    $('div#table-container').append(html);
}

function reloadTable() {
    var success = function (result) {
        refreshTable(result);
        generatePagination();
    }
    callback('GET', 'admin/menus', 'html', {output: 'table'}, success);
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
            callback('GET', 'admin/menus', 'html', {output: 'table', limit: limit, offset: (pageNumber - 1) * limit }, success);
        }
    });
}

function resetErrors() {
    $('#modal-menu-form-name').removeClass('has-error');
    $('#modal-menu-form-name .help-block').remove();
    $('#modal-menu-form-parent').removeClass('has-error');
    $('#modal-menu-form-parent .help-block').remove();
}

var success = function(result){
    if (result.success){
        reloadTable();
        $('#modal-menu').modal('hide');
        $('#modal-menu-submit').prop('disabled', false);
    }
}

var error = function(response) {
    if (response.status === 422) {
        for (var key in response.responseJSON) {
            var value = response.responseJSON[key];
            $('#modal-menu-form-' + key).addClass('has-error');
            $('#modal-menu-form-' + key).append('<p class="help-block">' + value + '</p>');
        }
        $('#modal-menu-submit').prop('disabled', false);
    }
}

var prepForm = function() {
    $('#modal-menu-submit').prop('disabled', true);
    resetErrors();
}

$(function() {
    $('#modal-menu').on('show.bs.modal', function (event) {
        // load data
        var button = $(event.relatedTarget);
        var action = button.data('action');
        var id = button.data('id') || 0;
        var name = button.data('name');
        var post_id = button.data('post-id');
        var parent_id = button.data('parent-id');
        // set data
        $('#modal-menu-label').text(action);
        $('#menu-id').val(id);
        $('#menu-name').val(name);
        // load post select
        callback('GET', 'admin/posts', 'json', [], function(result) {
            generatePosts(result);
            if (post_id) $('#menu-post').val(post_id);
        });
        // load parent select
        callback('GET', 'admin/menus/possible_parents/' + id, 'json', [], function(result) {
            generateParentMenus(result);
            if (parent_id) $('#menu-parent').val(parent_id);
        });
        // if submit add new
        if (action == 'Add New') {
            $('#modal-menu-submit').click(function() {
                prepForm();
                var data = {
                    name: $('#menu-name').val(),
                    post_id: $('#menu-post').val(),
                    parent: $('#menu-parent').val(),
                    _token: $('input#menu-post-token').val()
                };
                callback('POST', 'admin/menus', 'json', data, success, error);
            });
        }
        // if submit edit
        else if (action == 'Edit') {
            $('#modal-menu-submit').click(function() {
                prepForm();
                var data = {
                    name: $('#menu-name').val(),
                    post_id: $('#menu-post').val(),
                    parent: $('#menu-parent').val(),
                    _token: $('input#menu-post-token').val(),
                    _method: 'PATCH'
                };
                callback('POST', 'admin/menus/' + $('#menu-id').val(), 'json', data, success, error);
            });
        }
    });
    $('#modal-menu').on('hide.bs.modal', function (event) {
        $('#modal-menu-submit').unbind('click');
        resetErrors();
    });
    $('#modal-menu-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $('#modal-menu-delete-submit').click(function() {
            $('#modal-menu-delete').modal('hide');
            var data = {
                _token: $('input#menu-post-token').val(),
                _method: 'DELETE'
            };
            var success = function(result){
                if (result.success = true){
                    reloadTable();
                }
            }
            callback('POST', 'admin/menus/' + id, 'json', data, success);
        });
    })

    generatePagination();

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

});
//# sourceMappingURL=menus.js.map
