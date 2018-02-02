$(function(){
	var mySwiper = new Swiper('.swiper-container', {
		direction: 'horizontal',
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		loop: true,
		speed: 500,
		autoplay: 5000
	});
});
