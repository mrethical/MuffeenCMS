
let input_tags_container = null;
let div_tags_container = null;

let tags = [];
let tag_count = 0;
function add_tag_input(name) {
    if (tags.indexOf(name.toLowerCase()) !== -1) return false;
    let html = '<input type="hidden" class="tag" name="tags[]" id="tag-' + tag_count + '" value="' + name + '" />';
    input_tags_container.append(html);
    tags.push(name.toLowerCase());
    return tag_count++;
}

function add_tag_container(id) {
    if (id === false) return false;
    let tag_name = $('#tag-' + id).val();
    let html =
        `<div class="tag-container" id="tag-container-${id}">
            <span class="tag-name">${tag_name}</span>&nbsp;
            <button type="button" class="close" id="tag-container-delete-${id}" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    $(html).insertBefore('#tag-insert');
    $('#tag-container-delete-' + id ).click(function(){
        $('#tag-container-' + id).remove();
        let tag = $('#tag-' + id);
        tags.splice(tags.indexOf(tag.val()), 1);
        tag.remove();
    });
}

function create_tag_insert_input() {
    let html = 	`
        <div class="tag-container" id="tag-insert">
        	<span style="">New:</span>&nbsp;
        	<input type="text" class="typeahead form-control" id="tag-insert-name" />&nbsp;
        	<button type="button" class="btn btn-default" id="tag-insert-save">
        		<i class="fa fa-check" aria-hidden="true"></i>
        	</button>
        </div>
    `;
    div_tags_container.append($(html));
    let tag_insert_name = $('#tag-insert-name');
    tag_insert_name.typeahead({
        highlight: true,
    }, {
        name: 'tags',
        source: function(query, syncResults, asyncResults) {
            $.get(server_url + '/admin/posts/tags?search=1&keyword=' + query, function(data) {
                asyncResults(data);
            });
        }
    }).keypress(function (e) {
        let key = e.which;
        if (key == 13) { // the enter key code
            $('#tag-insert-save').click();
            return false;
        }
    });
    $('#tag-insert-save').click(function(){
        let name = tag_insert_name.val();
        if (name.length !== 0) {
            let id = add_tag_input(name);
            add_tag_container(id);
            tag_insert_name.val('');
        }
    });
}

$(function(){

    input_tags_container = $('#input-tags-container');
    div_tags_container = $('#div-tags-container');
    create_tag_insert_input();

    $('.tag').each(function(){
        tags.push($(this).val().toLowerCase());
        add_tag_container(tag_count);
        tag_count++;
    });

});
