
Dropzone.options.resourceDropzone = {
    paramName: "file",
    maxFilesize: 5,
    uploadMultiple: false,
    init: function()  {
        console.log('asd');
        console.log(this);
        this.on("error", (file, output) => {
            toastError(listValidationErrors(output));
        });
    }
};

$(document).ready(() => {

    $('button.upload-type').click(() => {
        let type_upload_button = $('button.upload-type');
        let type_upload = type_upload_button.data('type');
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

    $('select[name="category"]').change(() => {
        $('input[name="category"]').val($('select[name="category"]').val())
    });

});