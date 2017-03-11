
$(function(){
    Dropzone.options.resourceDropzone = {
        paramName: "resc-file",
        maxFilesize: 5,
        uploadMultiple: false,
    };

    $('button.upload-type').click(function(){
        var type_upload_button = $('button.upload-type');
        var type_upload = type_upload_button.data('type');
        if (type_upload === "single") {
            $('.multiple-upload').css('display', 'none');
            $('.single-upload').css('display', 'block');
            type_upload_button.data('type', "multiple");
            type_upload_button.text("Multiple Uploader");
        } else {
            $('.single-upload').css('display', 'none');
            $('.multiple-upload').css('display', 'block');
            type_upload_button.data('type', "single");
            type_upload_button.text("Single/Native Uploader");
        }
    });

    $('button#upload-type-1').click();

    $('select[name="category"]').change(function(){
        $('input[name="category"]').val($('select[name="category"]').val())
    });


});
//# sourceMappingURL=resource-create.js.map
