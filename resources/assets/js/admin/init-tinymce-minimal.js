
tinymce.init({
    selector: '.tinymce.minimal',
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