
$(function() {

    history.pushState("", document.title, window.location.pathname
        + window.location.search);

    var url = window.location;
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