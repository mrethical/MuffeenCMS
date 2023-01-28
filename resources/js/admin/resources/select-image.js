
let select_image_input = null;
let select_image_input_name = null;

function refreshImageCategories() {
    $.get( `${server_url}/admin/resources/categories?ordered=1`, (data) => {
        let html = `
            <option value="-1">All</option>
            <option value="0">Uncategorized</option>
        `;
        data.forEach((val) => {
            html += `<option value="${ val.id }">${ val.name }</option>`;
        });
        $('#modal-image-category').empty().append($(html)).trigger('change');
    })
        .fail((response) => {
            redirectUnauthorized(response);
            showErrorToast();
        });
}

function refreshImages(category_id) {
    $.get( `${server_url}/admin/resources/filter?images=1&category=${category_id}`, (data) => {
        let html = '';
        data.forEach((val) => {
            html += `
                <option data-img-src="${ uploads_small_url + val.name }"
                    data-main-img-src="${ uploads_url + val.name }"
                    value="${ val.id }">${ val.title }</option>`;
        });
        $('#modal-image-name').empty().append($(html));
        if (select_image_input !== null) {
            $('select.image-picker option[value="' + select_image_input.val() + '"]').prop("selected", true);
        }
        $("select.image-picker").imagepicker({
            show_label: true,
            initialized: function(){
                $('ul.image_picker_selector > li')
                    .prop('class', 'col-sm-5')
                    .css('padding', '0px')
                    .css('margin', '0px 20px 0px 0px');
                $('ul.image_picker_selector > li > div.thumbnail > p')
                    .css('word-wrap', 'break-word');
            }
        });
    })
        .fail((response) => {
            redirectUnauthorized(response);
            showErrorToast();
        });
}

$(document).ready(() => {

    $('#modal-image-category').change(function() {
        refreshImages(this.value);
    });

    $('#modal-image').on('show.bs.modal', function(event) {
        let element = $(event.relatedTarget);
        let temp = element.data('input');
        if (temp) {
            select_image_input = $(element.data('input'));
        }
        temp = element.data('input-name');
        if (temp) {
            select_image_input_name = $(element.data('input-name'));
        }
        refreshImageCategories();
    })
    .css('z-index', '65540');

    $('#modal-image-submit').click(function() {
        if (select_image_input !== null) {
            select_image_input.val($('#modal-image-name').val());
            select_image_input = null;
        }
        if (select_image_input_name !== null) {
            select_image_input_name.val($('#modal-image-name option:selected').data('main-img-src'));
            select_image_input_name = null;
        }
        $('#modal-image').modal('hide');
    });

});