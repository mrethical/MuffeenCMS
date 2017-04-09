let empty_table_row = '';

function generateRow(row_data) {
    let html = `
        <tr>
            <td>${row_data.title}</td>
            <td>${row_data.author.name}</td>
            <td>${ (row_data.category_id) ? row_data.category.name : '' }</td>
            <td>${timestamp(row_data.created_at)}</td>
            <td> 
                <a class="btn btn-default btn-xs" href="${server_url}/admin/posts/${row_data.id}/edit">Edit</a>
                <button type="button" class="btn btn-default btn-xs" data-action="Delete"
                    data-toggle="modal" data-target="#modal-delete" data-id="${row_data.id}">Delete
                </button>
            </td>
        </tr>
    `;

    return html;
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
    $.get( `${server_url}/admin/posts?page=${page}&limit=${limit}`, (data) => {
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
    $('#modal-delete').on('show.bs.modal', (event) => {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let name = button.data('name');
        $('#modal-delete-submit').click(() => {
            $('#modal-delete-submit').empty()
                .append($('<i class="fa fa-spin fa-fw fa-spinner"></i>'));
            let data  = `_token=${$('#user-token').val()}&_method=DELETE`;
            $.post( `${server_url}/admin/posts/${id}`, data)
                .done(() => {
                    refreshTable(1, 10);
                    $('#modal-delete').modal('hide');
                    toastSuccess('Post deleted successfully');
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