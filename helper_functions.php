<?php
date_default_timezone_set('Europe/Paris');
define('BASE_URL', 'http://awesomeit.nl');

/* 

  Will do the including of classes for you
  If you add a directory with classes add it to the classes array
*/

function __autoload($class)
{
  $classes = array("controller/$class", "helpers/$class", "models/$class", "models/$class/model");

  foreach ($classes as $class) // check as if we were an admin first
  {
    $class = '../' . $class . '.php';

    if (file_exists($class))
    {
      include_once($class);
      return true;
    }
  }

  foreach ($classes as $class)
  {
    $class = $class . '.php';

    if (file_exists($class))
    {
      include_once($class);
      return true;
    }
  }
  
  return false;
}

function get_template($page, $type, $path)
{
  if (isset($page['template']) && file_exists(sprintf($path, $page['template'])))
    return $page['template'];

  if (file_exists(sprintf($path, $type . '.php')))
    return $type . '.php';
  
  return 'full.php';
}

/* 
  Removes any punctuation from a title (breaks urls) then makes sure multiple
  spaces become one space, which is then converted to a dash.
*/
function clean($title)
{
  return trim(preg_replace(array('/[[:punct:]]/','/\s+/','/\s/'), array('', ' ', '-'), $title), '-');
  
}

/* 
  Removes comments, tabs, new lines and double unneeded spaces.
  Without breaking css/js
*/
function compress($input)
{
  return preg_replace(
    array('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '/\s+/', '/[\t\r\n]/', '/<!--(.*?)-->/', '/ ?([,:;{}()=|\#)<>]) ?/'), 
    array('', ' ', '', '', '$1'), 
    $input
  );
}

function data_uri($path)
{
  if (file_exists($path))
    return base64_encode(file_get_contents($path));
}

function create_url($item, $type='page')
{
  return sprintf(
    "<a href='%s/%s/%d/%s'>%s</a>", 
     BASE_URL,
	 $type,
     $item['ID'],
     clean($item['title']),
     $item['title']
  );
}

function create_option_list($items, $item_value, $item_label, $selected='')
{
  $option = '<option value="%s" %s>%s</option>';
  $list   = '<option></option>';
  
  foreach($items as $key => $value)
    $list .= sprintf($option, $value[$item_value], ($selected == $value[$item_value] ? 'selected' : ''), $value[$item_label]); 
  
  return $list;
}

function get_first($result)
{
  return is_array($result) ? array_shift($result) : false;
}

function extract_names($members)
{
  $result = array();

  foreach ($members as $member)
    $result[] = $member['firstname'] . ' ' . $member['tussenvoegsel'] . ' ' . $member['lastname'];

  return $result;
}

function get_files($dir, $files_to_skip=False)
{
  if (is_dir($dir) && ($dh = opendir($dir)))
  {
    $list = array();
    
    while(($file = readdir($dh)) !== false)
      if (is_array($files_to_skip) && in_array($file, $files_to_skip))
        continue;
      else if (strpos($file, '.php') || strpos($file, '.css') || strpos($file, '.js'))
        $list[] = $file;

    closedir($dh);
    return $list;
  }
}

function get_models()
{
  $models = array();

  $path = 'models';

  if (! is_dir($path))
    $path = '../' . $path;

  if ($classes = array_slice(scandir($path), 2))
    foreach ($classes as $class)
      if (strpos($class, 'default') === 0)
        continue;
      else
        $models[] = $class;

  return $models;
}

function check_404($type, $id)
{
  $models = get_models();

  if (strlen($type) > 0 && (! in_array(strtolower($type), $models) || ! is_numeric($id)))
    send_location_header(404, 'Not Found', 'page/404/Pagina-niet-gevonden'); 
}

function check_301($type, $id, $title)
{
  if ($title !== $title)
    send_location_header(301, 'Moved Permanently', "$type/$id/$title"); 
}

function send_location_header($code, $message, $location)
{
	header("HTTP/1.1 $code $message");
	header("Location: ".BASE_URL.'/'.$location);
  exit(0);
}

?>
