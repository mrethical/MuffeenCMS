
$(document).ready(() => {

    let $preview = $('#article-img-preview');

    $('#article-img').cropper({
        data: data,
        ready: function (e) {
            let $clone = $(this).clone().removeClass('cropper-hidden');

            $clone.css({
                display: 'block',
                width: '100%',
                minWidth: 0,
                minHeight: 0,
                maxWidth: 'none',
                maxHeight: 'none'
            });

            $preview.css({
                width: '100%',
                overflow: 'hidden'
            }).html($clone);
        },
        crop: function (e) {
            let imageData = $(this).cropper('getImageData');
            let previewAspectRatio = e.width / e.height;
            let previewWidth = $preview.width();
            let previewHeight = previewWidth / previewAspectRatio;
            let imageScaledRatio = e.width / previewWidth;

            $preview.height(previewHeight).find('#article-img').css({
                width: imageData.naturalWidth / imageScaledRatio,
                height: imageData.naturalHeight / imageScaledRatio,
                marginLeft: -e.x / imageScaledRatio,
                marginTop: -e.y / imageScaledRatio
            });

            $('#article-img-container').remove();
        }
    });
    
});