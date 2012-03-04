<?php
class table
{
  public static function get_show_in_overview_labels($params)
  {
    $result = array();

    foreach($params as $key => $value)
      if (array_key_exists('show-in-overview', $value) && $value['show-in-overview'])
        $result[$key] = $value['label'];

    return $result;
  }

  public static function create_row($row)
  {
    return '<td>' . implode('</td><td>', $row) . '</td>';
  }
}
?>
