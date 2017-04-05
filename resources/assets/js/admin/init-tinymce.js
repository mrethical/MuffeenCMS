
tinymce.init({
    selector: '.tinymce',
    height: 300,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    file_browser_callback: function(field_name) {
        $('#open-image-model').data("input-name", '#' + field_name);
        $('#open-image-model').click();
    },
    relative_urls : false
});