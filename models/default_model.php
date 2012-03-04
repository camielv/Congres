<?php
class default_model
{
  public $controller = False,
         $user_permission,
         $params,
         $class_name,
         $single,
         $plural;

  public function get_user_permission()
  {
    return $this->user_permission;
  }

  public function find_all()
  {
    return $this->controller->select_all($this->class_name);
  }

  public function find_by_id($id)
  {
    return $this->controller->select_by_id($id, $this->class_name);
  }
}
?>