// LEFT
function changeLeft() {
	i--;
	if(i<3) i=count+2;
	changeSlide(i);
}

// RIGHT
function changeRight() {
	i++;
	if(i>count+2) i=3;
	changeSlide(i);
}

// AUTOMATIC
function change() {
	i++;
	if(i>count+2) i=3;
	selectImage();
}

function changeSlide(id) {
	i = id;
	$('.secondslide').css("background-image", $('.firstslide').css("background-image"));
	$('.secondslide').html($('.firstslide').html());
	
	clearInterval(changeInterval);
	$(".bullet").bind('click', function(e){
    	e.preventDefault();
	})
	$("#left").bind('click', function(e){
		e.preventDefault();
	})
	$("#right").bind('click', function(e){
		e.preventDefault();
	})
	$('.firstslide').fadeOut(100, function() {
		$('.firstslide').css("background-image", $('.slides :nth-child(' + i + ')').css("background-image"));
		$('.firstslide').html($('.slides :nth-child(' + i + ')').html());
		$('.firstslide').fadeIn(1000, function() {
			changeInterval = setInterval(function() { 
				change();
			} , 5400);
			$('.bullet').unbind('click');
			$('#left').unbind('click');
			$('#right').unbind('click');
		});
	});
	$('.bullet').removeClass("selected");
	$('#bullet' + (i - 2)).addClass("selected");
}

function selectImage() {
	$('.secondslide').css("background-image", $('.firstslide').css("background-image"));
	$('.secondslide').html($('.firstslide').html());
	$(".bullet").bind('click', function(e){
		e.preventDefault();
	})
	$("#left").bind('click', function(e){
		e.preventDefault();
	})
	$("#right").bind('click', function(e){
		e.preventDefault();
	})
	$('.firstslide').fadeOut(100, function() {
		$('.firstslide').css("background-image", $('.slides :nth-child(' + i + ')').css("background-image"));
		$('.firstslide').html($('.slides :nth-child(' + i + ')').html());
		$('.firstslide').fadeIn(1000, function() {
			$('.bullet').unbind('click');
			$('#left').unbind('click');
			$('#right').unbind('click');
		});
	});
//		$('.slides :eq(' + $i + ')').next().show().end().fadeOut(1200).appendTo('.slides');
	$('.bullet').removeClass("selected");
	$('#bullet' + (i - 2)).addClass("selected");
}

$(window).load(function() {
	count = $('.slides').children().length - 2;
	i = 3;
	if(count > 1) {
		changeInterval = setInterval(function() { 
			change();
		} , 5400);
	} else {
		$('#bullet1').hide();
		$('#left').hide();
		$('#right').hide();
	}
});