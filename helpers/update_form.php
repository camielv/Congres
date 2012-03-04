<?php
class update_form extends form
{
  public $model, $params, $type, $item, $ID;

  public function __construct($args)
  {
    $this->model = $args['model'];
    $this->params = $args['model']->params;
    $this->type = $this->model->class_name;
    $this->ID = $args['ID'];
    $this->item = $this->model->find_by_id($this->ID);
  }
}
?>
