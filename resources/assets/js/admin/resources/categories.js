let empty_table_row = '';

function generateRow(row_data) {
    return `
        <tr>
            <td>${row_data.name}</td>
            <td> 
                <button type="button" class="btn btn-default btn-xs" data-action="Edit"
                    data-toggle="modal" data-target="#modal-category"
                    data-id="${row_data.id}" data-name="${row_data.name}">Edit</button>
                <button type="button" class="btn btn-default btn-xs" data-action="Delete"
                    data-toggle="modal" data-target="#modal-delete" 
                    data-id="${row_data.id}">Delete</button>
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
    $.get( `${server_url}/admin/resources/categories?page=${page}&limit=${limit}`, (data) => {
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
    let modal_category = $('#modal-category');
    modal_category.on('show.bs.modal', (event) => {
        let button = $(event.relatedTarget);
        let action = button.data('action');
        let submit = $('#modal-category-submit');
        $('#modal-category-label').text(action + ' Category');
        if (action === 'Add New') {
            submit.click(() => {
                submit.empty().append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
                let data = `_token=${$('#_token').val()}&name=${$('#name').val()}`;
                $.post( server_url + '/admin/resources/categories', data)
                    .done(() =>{
                        refreshTable(1, 10);
                        modal_category.modal('hide');
                        toastSuccess('Category added successfully');
                    })
                    .fail((response) =>{
                        redirectUnauthorized(response);
                        removeValidationAlerts();
                        showValidationAlert(response, $('#modal-category-body'));
                        submit.empty().append("Submit");
                    });
            });
        } else if (action === 'Edit') {
            let id = button.data('id');
            let name = button.data('name');
            $('#name').val(name);
            submit.click(() => {
                submit.empty().append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
                let data = `_token=${$('#_token').val()}&_method=PATCH&name=${$('#name').val()}`;
                $.post( server_url + '/admin/resources/categories/' + id, data)
                    .done(() =>{
                        refreshTable(1, 10);
                        modal_category.modal('hide');
                        toastSuccess('Category updated successfully');
                    })
                    .fail((response) =>{
                        redirectUnauthorized(response);
                        removeValidationAlerts();
                        showValidationAlert(response, $('#modal-category-body'));
                        submit.empty().append("Submit");
                    });
            });
        }
        setTimeout(() => {
            $("#name").focus();
        }, 500);
    }).on('hide.bs.modal', () => {
        removeValidationAlerts();
        $('#name').val('');
        $('#modal-category-submit').empty().append("Submit").unbind('click');
    });
    
    $('#modal-delete').on('show.bs.modal', (event) => {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let name = button.data('name');
        $('#modal-delete-submit').click(() => {
            $('#modal-delete-submit').empty()
                .append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
            let data  = `_token=${$('#_token').val()}&_method=DELETE`;
            $.post( `${server_url}/admin/resources/categories/${id}`, data)
                .done(() => {
                    refreshTable(1, 10);
                    $('#modal-delete').modal('hide');
                    toastSuccess('Category deleted successfully');
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