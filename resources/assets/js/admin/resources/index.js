
let empty_table_row = '';

let image_ext = ['jpg', 'jpeg', 'png', 'gif'];

function generateRow(row_data) {
    return `
        <tr>
            <td>
            <button class="btn btn-link" data-toggle="modal" data-target="#modal-resource-preview" 
                data-name="${row_data.name}">
                <img class="resource-image" src="${
                    (image_ext.indexOf(row_data.ext.toLowerCase()) > -1)
                        ? uploads_small_url + row_data.name : filetypes_url + row_data.ext + '.png'
                }" />
            </button>
            <a class="resource-title" href="${ uploads_url + row_data.name }" target="_blank">
                ${ row_data.title }</a>
            <td>${ (row_data.category !== null) ? row_data.category.name : '' }</td>
            <td>${ timestamp(row_data.created_at) }</td>
            <td> 
                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-edit"
                    data-id="${ row_data.id }"
                    data-name="${ row_data.name }"
                    data-title="${ row_data.title }"
                    data-category="${ (row_data.category_id) ? row_data.category_id : 0 }"
                    data-alt="${ row_data.alt }"
                    data-size="${ format_bytes(row_data.size, 'KB') }"
                    data-type="${ row_data.ext }">Edit</button>
                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-delete"
                    data-action="Delete" data-id="${ row_data.id  }">Delete</button>
            </td>
        </tr>
    `;
}

function generatePagination(count, limit) {
    let pagination = $('#pagination');
    if (pagination.data('count') !== count) {
        pagination.pagination({
            prevText: '<<',
            nextText: '>>',
            items: count,
            itemsOnPage: limit,
            onPageClick: (pageNumber) => {
                pagination.hide();
                refreshTable(pageNumber, limit);
                return false;
            }
        });
        pagination.data('count', count);
    } else {
        pagination.show();
    }
    pagination.find('ul').addClass('pagination');
}

function refreshTable(page, limit) {
    $('.overlay').show();
    $.get( `${server_url}/admin/resources?page=${page}&limit=${limit}`, (data) => {
        let html = '';
        if (data.list.length === 0) {
            html = empty_table_row;
        } else {
            data.list.forEach((val) => {
                html += generateRow(val);
            });
            html = $(html);
        }
        $('#table-body').empty().append(html);
        generatePagination(data.count, limit);
        $('.overlay').hide();
    })
        .fail((response) => {
            redirectUnauthorized(response);
            showErrorToast();
        });
}

$(document).ready(() => {
    let modal_edit = $('#modal-edit');
    modal_edit.on('show.bs.modal', (event) => {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        $('#src').prop("src", server_url + "/uploads/images-small/" + button.data('name'));
        $('#name').text(button.data('name'));
        $('#type').text(button.data('type').toUpperCase() + " File");
        $('#size').text(button.data('size'));
        $('#title').val(button.data('title'));
        $('#alt').val(button.data('alt'));
        if (button.data('category') !== 0) {
            $("#category").val(button.data('category'));
        }
        let submit = $('#modal-resource-submit');
        submit.click(() => {
            submit.empty().append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
            let data = $('#modal-edit-body').serialize();
            data += `&_token=${$('#_token').val()}&_method=PATCH`;
            $.post( server_url + '/admin/resources/' + id, data)
                .done(() =>{
                    refreshTable(1, 10);
                    modal_edit.modal('hide');
                    toastSuccess('Category updated successfully');
                })
                .fail((response) =>{
                    redirectUnauthorized(response);
                    removeValidationAlerts();
                    showValidationAlert(response, $('#modal-edit-body'));
                    submit.empty().append("Submit");
                });
        });
        setTimeout(() => {
            $("#title").focus();
        }, 500);
    }).on('hide.bs.modal', () => {
        removeValidationAlerts();
        $('#name').val('');
        $('#modal-resource-submit').empty().append("Submit").unbind('click');
    });
    
    $('#modal-delete').on('show.bs.modal', (event) => {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        $('#modal-delete-submit').click(() => {
            $('#modal-delete-submit').empty()
                .append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
            let data = `_token=${$('#_token').val()}&_method=DELETE`;
            $.post( `${server_url}/admin/resources/${id}`, data)
                .done(() => {
                    refreshTable(1, 10);
                    $('#modal-delete').modal('hide');
                    toastSuccess('Resource deleted successfully');
                })
                .fail((response) => {
                    redirectUnauthorized(response);
                    showErrorToast();
                    $('#modal-delete').modal('hide');
                });
        })
    }).on('hide.bs.modal', () => {
        $('#modal-delete-submit').empty()
            .append("Ok")
            .unbind('click');
    });

    empty_table_row = $('.empty-table-row');

    refreshTable(1, 10);
});