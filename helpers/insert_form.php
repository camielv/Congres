<?php
class insert_form extends form
{
  public $model, $params, $type;

  public function __construct($args)
  {
    $this->model = $args['model'];
    $this->params = $args['model']->params;
    $this->type = $this->model->class_name;
  }
}
?>