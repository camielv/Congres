function slideSwitch() {
    var $active = $('#slideshow IMG.active');

    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

    var $next =  $active.next().length ? $active.next()
        : $('#slideshow IMG:first');

    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

var menu = $('.nav li');

menu.hover(function()
{
  $(this).toggleClass('hover').find('ul').first().toggle();
});

function showItem(id) {
	document.getElementsByClassName('show')[0].className = 'hide';
	var ids = document.getElementsByClassName('hide');
	for (i=0; i<ids.length; i++){
		if(i == id) {
			ids[i].className = 'show';
		} else {
			ids[i].className = 'hide';
		}
	}
}

function displayOption(id) {
	var items = id.options;
	for (i = 1; i < items.length; i++) {
		if( id.value == items[i].value) {
			document.getElementById(items[i].value).className = 'show';
		} else {
			document.getElementById(items[i].value).className = 'hide';
		}
	}
}

function toggle(id) {
	$(id).toggle();
}
