
let maxDepth = 2;
let menu_item_counter = 0;
let sort_menu_stack = [];

function getMenuChildrenHtml(id, name, url, children = []) {
    let html = `
        <li id="menu-item-${id}"data-id="${id}" data-name="${name}" data-url="${url}">
            <span class="drag"><b>${name}</b></span>
            <div class="pull-right">
                <button class="btn btn-default btn-flat btn-xs"
                    data-toggle="modal" data-target="#modal-item" data-action="Edit"
                     data-id="${id}" data-name="${name}" data-url="${url}">Edit</button>
                <button class="btn btn-default btn-flat btn-xs delete-item"
                    data-target="#menu-item-${id}">Delete</button>
              </div>
            <ul class="sub-menu">
    `;
    for(let i = 0; i < children.length; i++) {
        if (children[i].length === 0) {
            continue;
        }
        html += getMenuChildrenHtml(children[i].id, children[i].name, children[i].url, children[i].children[0]);
    }
    html += `
            </ul>
        </li>
    `;
    return html;
}

function prepareMenu()
{
    let menu = sort_menu_stack[sort_menu_stack.length-1][0];
    let html = '';
    for(let i = 0; i < menu.length; i++) {
        html += getMenuChildrenHtml(menu[i].id, menu[i].name, menu[i].url, menu[i].children[0]);
    }
    return html;
}

function sortMenu() {
    let menu = $("ul.menu")
        .empty()
        .append($(prepareMenu()))
        .sortable({
        // http://stackoverflow.com/questions/40616805/jquery-sortable-limit-nesting-level
        isValidTarget: function ($item, container) {
            let depth = 1, children = $item.find('ul').first().find('li');
            depth += container.el.parents('ul').length;
            while (children.length) {
                depth++;
                children = children.find('ul').first().find('li');
            }
            return depth <= maxDepth;
        },
        handle: 'span.drag',
        onDrop: function ($item, container, _super) {
            let data = menu.sortable("serialize").get();
            if (JSON.stringify(sort_menu_stack[sort_menu_stack.length-1]) !== JSON.stringify(data)) {
                sort_menu_stack.push(data);
                enableUndo();
            }
            _super($item, container);
        }
    });
    $('.delete-item').click(function () {
        $($(this).data('target')).remove();
        sort_menu_stack.push(menu.sortable("serialize").get());
        enableUndo();
    });
    enableUndo();
}

function enableUndo()
{
    if (sort_menu_stack.length > 1) {
        $('#undo').prop('disabled', false);
    } else {
        $('#undo').prop('disabled', true);
    }
}

function addItem(name, url) {
    let new_item = JSON.parse(JSON.stringify(sort_menu_stack[sort_menu_stack.length-1]));
    sort_menu_stack.push(new_item);
    sort_menu_stack[sort_menu_stack.length-1][0].push({
        "id": --menu_item_counter,
        "name": name,
        "url": url,
        "children": [[]]
    });
    sortMenu();
    enableUndo();
}

function editItem(id, name, url) {
    let new_item = JSON.parse(JSON.stringify(sort_menu_stack[sort_menu_stack.length-1]));
    new_item = searchAndModifyChildren(new_item, id, name, url);
    sort_menu_stack.push(new_item);
    sortMenu();
    enableUndo();
}

function searchAndModifyChildren(children, id, name, url) {
    for(let i = 0; i < children[0].length; i++) {
        if (children[0][i].id === id) {
            children[0][i].name = name;
            children[0][i].url = url;
            break;
        } else {
            children[0][i].children = searchAndModifyChildren(children[0][i].children,  id, name, url);
        }
    }
    return children;
}

function prepareSendData(array) {
    let data = [];
    for(let i = 0; i < array[0].length; i++) {
        data.push({
            id: array[0][i].id,
            name: array[0][i].name,
            url: array[0][i].url,
            children: prepareSendData(array[0][i].children)
        })
    }
    return data;
}

function prepareRetreivedData(data) {
    let no_parent_yet = [];
    let new_data = [[]];
    for(let i = 0; i < data.length; i++) {
        if (data[i].order.parent_menu_id !== null) {
            let temp = searchAndAppendChildren(new_data, data[i]);
            if (temp === null) {
                no_parent_yet.push(data[i]);
            } else {
                new_data = temp;
            }
        } else {
            new_data[0].push({
                id: data[i].id,
                name: data[i].name,
                url: data[i].url,
                children: [[]]
            });
        }
    }
    sort_menu_stack.push(new_data);
}

function searchAndAppendChildren(children, data) {
    let new_children = null;
    for(let i = 0; i < children[0].length; i++) {
        if (children[0][i].id === data.order.parent_menu_id) {
            children[0][i].children[0].splice(data.order.order, 0, {
                id: data.id,
                name: data.name,
                url: data.url,
                children: [[]]
            });
            new_children = children;
            break;
        } else {
            let temp = searchAndAppendChildren(children[0][i].children, data);
            if (temp !== null) {
                new_children = temp;
                break;
            }
        }
    }
    return new_children;
}

$(document).ready(() => {
    $.get( `${server_url}/admin/menus/${$('#id').val()}/edit`, (data) => {
        prepareRetreivedData(data);
        sortMenu();
    }).fail((response) => {
        redirectUnauthorized(response);
        showErrorToast();
    });

    $('#undo').click(() => {
        sort_menu_stack.pop();
        sortMenu();
    });

    $('#modal-item').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let action = button.data('action');
        let submit = $('#modal-item-submit');
        $('#modal-item-label').text(action + ' Item');
        if (action === 'Add New') {
            $('#url').val('#');
            submit.click(() => {
                addItem($('#name').val(), $('#url').val());
                $('#modal-item').modal('hide');
            });
        } else if (action === 'Edit') {
            let id = button.data('id');
            $('#name').val(button.data('name'));
            $('#url').val(button.data('url'));
            submit.click(() => {
                editItem(id, $('#name').val(), $('#url').val());
                $('#modal-item').modal('hide');
            });
        }
        submit.prop('disabled', true);
        setTimeout(() => {
            $("#name").focus();
        }, 500);
    }).on('hide.bs.modal', function () {
        $('#name').val('');
        $('#url').val('');
        $('#modal-item-submit').unbind('click');
    });

    $('.item-edit').on('input', function() {
        if ($('#name').val().length === 0) {
            $('#modal-item-submit').prop('disabled', true);
        } else {
            $('#modal-item-submit').prop('disabled', false);
        }
    });

    $('#save').click(function () {
        let data =
            `_token=${$('#_token').val()}` +
            `&_method=PATCH` +
            `&data=${JSON.stringify(prepareSendData(sort_menu_stack[sort_menu_stack.length-1]))}`;

        $.post( server_url + '/admin/menus/' + $('#id').val(), data)
            .done(() =>{
                toastSuccess('Menu saved successfully');
            })
            .fail((response) =>{
                redirectUnauthorized(response);
                showErrorToast();
            });
    })
});