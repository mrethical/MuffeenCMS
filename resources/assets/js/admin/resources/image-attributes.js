
let image_attributes_input = null;
let image_attributes_temp = {};

$(document).ready(() => {
    $('.image-attributes').click(function() {
        let element = $(this);
        let temp = element.data('input');
        let src = '';
        if (temp) {
            image_attributes_input = $(element.data('input'));
            if (image_attributes_input.val().length !== 0) {
                src = image_attributes_input.val();
            }
        }
        if (src.length === 0) {
            toastError('Image source is not set.')
        } else {
            let modal_body = $('#modal-image-attributes .modal-body');
            modal_body.empty();
            $('#modal-image-attributes').modal('show');
            $('.overlay').fadeIn(300);
            setTimeout(() => {
                let image = $('<img class="img img-responsive">');
                modal_body.append(image);
                let x = $('#image-x');
                let y = $('#image-y');
                let width = $('#image-width');
                let height = $('#image-height');
                image.on('load', () => {
                    let cropper = {
                        movable: false,
                        zoomable: false,
                        rotatable: false,
                        scalable: false,
                        crop: function(e) {
                            image_attributes_temp.x = e.x;
                            image_attributes_temp.y = e.y;
                            image_attributes_temp.width = e.width;
                            image_attributes_temp.height = e.height;
                            console.log(image_attributes_temp);
                        }
                    };
                    let attr = {};
                    if (x.val().length !== 0) {
                        attr.x = parseFloat(x.val());
                    }
                    if (y.val().length !== 0) {
                        attr.y = parseFloat(y.val());
                    }
                    if (width.val().length !== 0) {
                        attr.width = parseFloat(width.val());
                    }
                    if (height.val().length !== 0) {
                        attr.height = parseFloat(height.val());
                    }
                    cropper.data = attr;
                    image.cropper(cropper);
                    $('.overlay').fadeOut(300);
                }).attr('src', src);
            }, 500);
        }
    });
    $('#modal-image-attributes-submit').click(function() {
        $('#image-x').val(image_attributes_temp.x);
        $('#image-y').val(image_attributes_temp.y);
        $('#image-width').val(image_attributes_temp.width);
        $('#image-height').val(image_attributes_temp.height);
        $('#modal-image-attributes').modal('hide');
    });
});