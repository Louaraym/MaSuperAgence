$(function () {

    let $contactButton = $('#contact-button');

    $contactButton.click(e => {
        e.preventDefault();
        $('#contact-form').slideDown();
        $contactButton.slideUp();

    })

});