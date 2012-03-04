<?php
class form
{
  public function display()
  {
    $html = '';

    foreach ($this->params as $key => $value)
      $html .= $this->create_input_field($key, $value);

    return $html;
  }

  public function create_input_field($key, $value)
  {
    $this->set_default_key_value($key, $value);

    return $this->add_label($value) .
           $this->add_field($key, $value);
  }

  public function add_field($key, $value)
  {
    $default = $this->set_default_key_value($key, $value);

    if (isset($value['type']))
    {
      switch ($value['type'])
      {
        case 'hidden': return $this->create_hidden_field($key, $default);
        case 'password': return $this->create_password_field($key);
        case 'textarea': return $this->create_textarea($key, $default);
        case 'text-editor': return $this->create_text_editor($key, $default);
        case 'option': return $this->add_select_options($key, $default, $value['options']);
      }
    }
    else
    {
      $class = isset($value['class']) ? $value['class'] : $key;

      return $this->create_text_field($key, $default, $class);
    }
  }

  public function set_default_key_value($key, $value)
  {
    if (isset($value['default']) && (!isset($this->item) || $this->item[$key] === ''))
      return $value['default'];
    else if (isset($this->item))
      return $this->item[$key];
    else
      return '';
  }

  public function add_label($value)
  {
    if (isset($value['label']) && !isset($value['type']) || (isset($value['type']) && $value['type'] !== 'hidden'))
      return sprintf('<label>%s</label>', $value['label']);
  }

  public function create_hidden_field($key, $default)
  {
    return "<input type='hidden' name='$key' value='$default'>";
  }

  public function create_password_field($key)
  {
    return "<input type='password' name='$key'>";
  }

  public function create_text_field($key, $default, $class)
  {
    return "<input type='text' name='$key' value='$default' class='$class'>";
  }

  public function create_textarea($key, $default)
  {
    return "<textarea name='$key'>$default</textarea>";
  }

  public function create_text_editor($key, $default)
  {
    ob_start();
      include('editor/editor.php');
      $html = ob_get_contents();
    ob_end_clean();

    return $html;
  }

  public function add_select_options($key, $default, $options)
  {
    if (! is_array($options))
      $options = $this->model->$options();

    return $this->create_selection_list($key, $options, $default);
  }

  /* TODO fix array_shift thing, too complicated */
  public function create_selection_list($key, $options, $selected)
  {
    $list = "<select name='$key'><option></option>";
    
    foreach($options as $option)
    {
      if (is_array($option))
        $list .= sprintf('<option value="%s" %s>%s</option>', ($id=array_shift($option)), ($selected == $id ? 'selected' : ''), $option['title']);
      else
        $list .= sprintf('<option %s>%s</option>', ($selected == $option ? 'selected' : ''), $option); 
    }

    return $list . '</select>';
  }
}
?>
