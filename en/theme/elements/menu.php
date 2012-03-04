<?php

$list = '<ul class="nav">';

/* Parent pages */
$parent_pages = $controller->select_all_by_tag_with_order('parent_ID', 0, 'pages', 'menu_priority DESC');

foreach ($parent_pages as $parent_page)
{
  if ($parent_page['menu_priority'] === 0)
    continue;

  $list .= '<li>' . create_url($parent_page);

  $child_pages = $controller->select_all_by_tag_with_order('parent_ID', $parent_page['ID'], 'page', 'menu_priority DESC');

  if (count($child_pages) > 0)
  {
    $list .= '<ul class="sub-nav">';

    foreach ($child_pages as $child_page)
      $list .= '<li>' . create_url($child_page) . '</li>';

    $list .= '</ul>';
  }

  $list .= '</li>';
}
if ( 0 ) {
	$list .= '<li><a href="http://app.awesomeit.nl">App</a></li>';
}
$list .= '<li><a href="http://awesomeit.nl"><span style="color: red;">Nederlands</span></a></li>';
echo $list . '</ul>';
?>
