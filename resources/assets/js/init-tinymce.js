
if ($('#tinymce-type').val() == 'minimal')  {
    console.log($('#tinymce-type').val());
    tinymce.init({
        selector: '.tinymce',
        height : 300,
        menubar: false,
        statusbar: false,
        plugins: [
            'lists link anchor',
            '',
            'contextmenu paste'
        ] ,
        toolbar: 'insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link'
    });
} else {
    tinymce.init({
        selector: '.tinymce',
        height : 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        file_browser_callback: function(field_name, url, type, win) {
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
                $('#' + field_name).val($('#modal-image-add #res-image option:selected').data('main-img-src'));
                $('#modal-image-add #res-image').prop('multiple', 'multiple');
                $('#modal-image-add').modal('hide');
            });
        },
        relative_urls : false
    });
}