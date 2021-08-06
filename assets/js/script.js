
// When Page Load
$(window).on('load', function () {
    $('.hide-paragraph').hide();
    $('.loader').fadeOut();
    $('#preloader').delay(200).fadeOut('slow');
});

$('#formInput').submit(function() {
	agree = $('.form-check-input');
	if (agree.prop('checked') == false) {
		return false;
	}
})


// Hide Paragpraph

$('.show-btn').on('click', function () {
    $('.show-btn').fadeOut(200);
    $('.hide-paragraph').fadeIn(200);

});



// Elemen Scrolling
// $('.quick-count').on('click', function (e) {
//     e.preventDefault();

//     var tujuan = $(this).attr('href')
//     var elemenTujuan = $(tujuan);

//     var jarak = elemenTujuan.offset().top - 50;

//     $('html').animate({
//         scrollTop: jarak
//     }, 1000, 'swing')


// })