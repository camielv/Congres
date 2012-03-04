var menu = $('.nav li');

menu.hover(function()
{
  $(this).toggleClass('hover').find('ul').first().toggle();
});

function showItem(id) {
	print('%s', id);
    document.getElementById(id).style.display="block";
}
