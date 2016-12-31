
function refreshTable(html) {
    $('div#table-container').empty();
    $('div#table-container').append(html);
}

function reloadTable() {
    var success = function (result) {
        refreshTable(result);
        generatePagination();
    }
    callback('GET', 'admin/resources', 'html', {output: 'table'}, success);
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
            callback('GET', 'admin/resources', 'html', {output: 'table', limit: limit, offset: (pageNumber - 1) * limit }, success);
        }
    });
}

function resetErrors() {
    $('#modal-resource-form-title').removeClass('has-error');
    $('#modal-resource-form-title .help-block').remove();
}

var success = function(result){
    if (result.success){
        reloadTable();
        $('#modal-resource').modal('hide');
        $('#modal-resource-submit').prop('disabled', false);
    }
}

var error = function(response) {
    if (response.status === 422) {
        for (var key in response.responseJSON) {
            var value = response.responseJSON[key];
        }
        $('#modal-resource-form-' + key).addClass('has-error');
        $('#modal-resource-form-' + key).append('<p class="help-block">' + value + '</p>');
        $('#modal-resource-submit').prop('disabled', false);
    }
}

var prepForm = function() {
    $('#modal-resource-submit').prop('disabled', true);
    resetErrors();
}

$(function() {
    $('#modal-resource-preview').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name = button.data('name');
        $(this).find('h4.modal-title').text(name);
        $(this).find('img').attr('src', server_dir + 'uploads/' + name);
    });
    $('#modal-resource-preview').on('hide.bs.modal', function (event) {
        $(this).find('h4.modal-title').text('');
        $(this).find('img').attr('src', '');
    });
    $('#modal-resource').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $(this).find('img.res-info-src').prop("src", server_dir + "uploads/images-small/" + button.data('name'));
        $(this).find('p.res-info-name span').text(button.data('name'));
        $(this).find('p.res-info-type span').text(button.data('type').toUpperCase() + " File");
        $(this).find('p.res-info-size span').text(button.data('size'));
        $(this).find('#res-id').val(button.data('id'));
        $(this).find('#res-title').val(button.data('title'));
        $(this).find('#res-alt').val(button.data('alt'));
        $("#res-category").val(button.data('category'));
        $('#modal-resource-submit').click(function() {
            prepForm();
            var data = {
                title: $(' #res-title').val(),
                category_id: $('#res-category').val(),
                alt: $('#res-alt').val(),
                _token: $('#res-resource-token').val(),
                _method: 'PATCH'
            };
            callback('POST', 'admin/resources/' + $('#res-id').val(), 'json', data, success, error);
        });
    })
    $('#modal-resource-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        $('#modal-resource-delete-submit').click(function() {
            $('#modal-resource-delete').modal('hide');
            var data = {
                _token: $('input#res-resource-token').val(),
                _method: 'DELETE'
            };
            var success = function(result){
                if (result.success){
                    reloadTable();
                }
            }
            callback('POST', 'admin/resources/' + id, 'json', data, success);
        });
    })

    generatePagination();

    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });

});