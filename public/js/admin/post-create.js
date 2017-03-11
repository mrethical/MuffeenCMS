
var input_tags_container = null; // set this at onload
var div_tags_container = null; // set this at onload

var tags = [];
var tag_count = 0;
function add_tag_input(name) {
    if (tags.indexOf(name.toLowerCase()) != -1) return false;
    var html = '<input type="hidden" class="post-tag" name="tags[]" id="post-tag-' + tag_count + '" value="' + name + '" />';
    input_tags_container.append(html);
    tags.push(name.toLowerCase());
    return tag_count++;
}

function add_tag_container(id) {
    if (id === false) return false;
    var tag_name = $('#post-tag-' + id).val();
    var html = 	'<div class="post-tag-container" id="post-tag-container-' + id + '">'
        +		'<span class="post-tag-name">' + tag_name + '</span>&nbsp;'
        +		'<button type="button" class="close" id="post-tag-container-delete-' + id  + '" aria-label="Close">'
        +			'<span aria-hidden="true">&times;</span>'
        +		'</button>'
        +	'</div>';
    $(html).insertBefore('#post-tag-insert');
    $('#post-tag-container-delete-' + id ).click(function(){
        $('#post-tag-container-' + id).remove();
        tags.splice(tags.indexOf($('#post-tag-' + id).val()), 1);
        $('#post-tag-' + id).remove();
    });
}

function create_tag_insert_input() {
    var html = 	'<div class="post-tag-container" id="post-tag-insert">'
        +		'<span style="">New:</span>&nbsp;'
        +		'<input type="text" class="typeahead form-control" id="post-tag-insert-name" />&nbsp;'
        +		'<button type="button" class="btn btn-default" id="post-tag-insert-save">'
        +			'<i class="fa fa-check" aria-hidden="true"></i>'
        +		'</button>'
        +	'</div>';
    div_tags_container.append($(html));
    $('#post-tag-insert-name').typeahead({
        highlight: true,
    }, {
        name: 'tags',
        source: function(query, syncResults, asyncResults) {
            $.get(server_dir + 'admin/posts/tags?output=search&keyword=' + query, function(data) {
                asyncResults(data);
            });
        }
    });
    $('#post-tag-insert-save').click(function(){
        var name = $('#post-tag-insert-name').val();
        if (name != '') {
            var id = add_tag_input(name);
            add_tag_container(id);
            $('#post-tag-insert-name').val('');
        }
    });
    $('#post-tag-insert-name').keypress(function (e) {
        var key = e.which;
        if (key == 13) { // the enter key code
            $('#post-tag-insert-save').click();
            return false;
        }
    });
}

$(function(){

    input_tags_container = $('#tags-container > #input-tags-container');
    div_tags_container = $('#tags-container > #div-tags-container');
    create_tag_insert_input();

    $('.post-tag').each(function(){
        tags.push($(this).val().toLowerCase());
        add_tag_container(tag_count);
        tag_count++;
    });

    $('#categories-filter').change(function(){
        var success = function(result) {
            $('#res-image').empty();
            $('#res-image').append(result);
            $("select.image-picker").imagepicker({
                show_label: true,
                initialized: function(){
                    $('ul.image_picker_selector > li').prop('class', 'col-sm-5');
                    $('ul.image_picker_selector > li').css('padding', '0px');
                    $('ul.image_picker_selector > li').css('margin', '0px 20px 0px 0px');
                    $('ul.image_picker_selector > li > div.thumbnail > p').css('word-wrap', 'break-word');
                }
            });
        };
        callback('GET', 'admin/resources/categories/' + $(this).val(), 'html',
            {output: 'resources_select_options', image_only: 'true'}, success);
    });

    $('#add-image').click(function(){
        $('#modal-image-add #res-image').prop('multiple', '');
        $("select.image-picker").imagepicker({
            show_label: true,
            initialized: function(){
                $('ul.image_picker_selector > li').prop('class', 'col-sm-5');
                $('ul.image_picker_selector > li').css('padding', '0px');
                $('ul.image_picker_selector > li').css('margin', '0px 20px 0px 0px');
                $('ul.image_picker_selector > li > div.thumbnail > p').css('word-wrap', 'break-word');
            }
        });
        $('#modal-image-add').modal("show");
        $('#modal-image-submit').click(function() {
            $('#modal-image-submit').unbind('click');
            $('#post-image').val($('#modal-image-add #res-image').val());
            $('#post-image-name').val($('#modal-image-add #res-image option:selected').data('main-img-src'));
            $('#modal-image-add #res-image').prop('multiple', 'multiple');
            $('#modal-image-add').modal('hide');
        });
    });

    $('#modal-image-add').css('z-index', '65540');

});

//# sourceMappingURL=post-create.js.map
