
function slugify(text)
{
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

function makeSlug(element) {
    let related_slug = element;
    related_slug.attr('autocomplete', 'off');
    let related = related_slug.data('related');
    if (related != null) {
        $(related).on('input',function(){
            related_slug.val(slugify($(this).val()));
        });
        related_slug.on('input',function(){
            $(related).unbind('input');
        });
    }
}

$(document).ready(() => {
    $('.slug').each(function() {
        makeSlug($(this));
    });
});