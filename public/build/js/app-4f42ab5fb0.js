function smallModal(message){
    $('#smallModal').modal('show');
    $('#smallModalContent').text(message);
}

$('#btnMenu').click(function(){
    el = $('.menuMobile');
    el.addClass('slideInLeft animated');
    el.addClass('showMobileMenu');
    el.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
        function (e) {
            el.removeClass('slideInLeft');
        });
    $('body').append("<div id='backdrop' class='modal-backdrop fade in'></div> ");
    $('#backdrop').click(function(){
        el.addClass('slideOutLeft animated');

        el.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
            function (e) {
                el.removeClass('slideOutLeft');
                el.removeClass('showMobileMenu');
                $('#backdrop').remove();
            });

    });
});

$("#updateProfilePictureSpan").click(function(){
    $('#modalChangeProfilePicture').modal('show');
});

$(window).resize(function(){
    if($(window).width()>=768) {
        el = $('.menuMobile');
        el.removeClass('slideOutLeft');
        el.removeClass('showMobileMenu');
        $('#backdrop').remove();
    }
});
//# sourceMappingURL=app.js.map
