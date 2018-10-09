$(function() {

	// Скролинг по якорям
	$('.anchor').bind("click", function(e){
		var anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $(anchor.attr('href')).offset().top-106 // отступ от меню
		}, 500);
	e.preventDefault();
	});

	// Клик по гамбургеру на моб версии
	$('.mnu-mob__btn').click(function() {
		$('.mnu-mob').toggleClass('show');
	});
	$('.mnu-mob .nav-mnu__li').click(function() {
		$('.mnu-mob').removeClass('show');
	});

	// Отправка формы
	$('form').submit(function() {
		var form = $(this);
		var data = new FormData(form[0]);
		var goalId = $(this).find('input[ name="goal"]').val();
		var good = $(this).data('good');
		var link = $(this).data('link');
		$.ajax({
			type: 'POST',
			url: 'mail.php',
			data: data,
			contentType: false,
			processData: false,
			success: (function() {
				$.fancybox.close();
				if (good == true) {
					window.open(link, "_blank");
					$.fancybox.open('<div class="thn"><h3>Заявка отправлена!</h3><p>С Вами свяжутся в ближайшее время.</p></div>');
				} else {
					$.fancybox.open('<div class="thn"><h3>Заявка отправлена!</h3><p>С Вами свяжутся в ближайшее время.</p></div>');
				}
				//gtag('event','submit',{'event_category':'submit','event_action':goalId});
				//fbq('track', 'Lead');
			})()
		});
		return false;
	});

	// Инит фансибокса
	$('.fancybox').fancybox({
		margin: 0,
		padding: 0
	});

	$('.gallery-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		dots: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					dots: false
				}
			}
		]
	});

	$('.goods-slider').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		fade: true,
		dots: true,
		adaptiveHeight: true
	});

	$('.about-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.about-nav'
	});
	$('.about-nav').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		asNavFor: '.about-for',
		focusOnSelect: true
	});

	document.getElementById('mov').play();

	$('.goods-slider .slick-dots li:last-child').click(function () {
		var anchor = $('.goods-slider');
		$('html, body').stop().animate({
			scrollTop: $(anchor).offset().top-106 // отступ от меню
		}, 300);
	});

	$(".scroll").each(function () {
		var block = $(this);
		$(window).scroll(function() {
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				var top = block.offset().top-0;
			} else {
				var top = block.offset().top+0;
			}
			var bottom = block.height()+top;
			top = top - $(window).height();
			var scroll_top = $(this).scrollTop();
			if ((scroll_top > top) && (scroll_top < bottom)) {
				if (!block.hasClass("animated")) {
					block.addClass("animated");
					block.trigger('animatedIn');
				}
			}
		});
	});

});

$(window).on('load', function () {
    $('[data-src]').each(changeDataSrcToSrc);
});

function changeDataSrcToSrc(i, e) {
    e.src = $(e).data('src');
}
