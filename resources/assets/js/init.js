
$(function() {

    var url = window.location;

    console.log(url.href);

    if (url.href.endsWith("/#")) {
        history.pushState("", document.title, window.location.pathname
            + window.location.search);
    }

    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).parent().addClass('active');

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }

});