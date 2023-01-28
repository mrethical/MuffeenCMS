
$(document).ready(() => {
    if ($(window).width() > 767) {
        $('#posts .blog-image-container img').each(function(){
            $(this).parent().css('height', this.width / 4 * 3);
            $(this).css('width', 'auto');
        });
    }
});