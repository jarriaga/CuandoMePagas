function smallModal(message){
    $('#smallModal').modal('show');
    $('#smallModalContent').text(message);
}

$('#btnMenu').click(function(){
    el = $('.menuMobile');
    el.addClass('slideInLeft animated');
    el.show();
    el.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',
        function (e) {
            el.removeClass('slideInLeft');
        });
});
//# sourceMappingURL=app.js.map
