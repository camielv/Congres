<?php
class pages extends default_model
{
	  public function __construct($controller)
	  {
		$this->controller = $controller;
		$this->class_name = get_class();

    $this->single = 'Pagina';
    $this->plural = 'Paginas';

    $this->user_permission = array(
      'visible_in_sidebar' => BASIC,
      'overview' => BASIC,
      'insert' => ANY_COMMITTEE_CHAIRPERSON,
      'update' => ANY_COMMITTEE_CHAIRPERSON
    );

    $this->params = array
    (
      'ID' => array
      (
        'type' => 'hidden'
      ),

      'title' => array
      (
        'label' => 'Titel',
        'show-in-overview' => True
      ),

      'description' => array
      (
        'type' => 'textarea',
        'label' => 'Korte omschrijving'
      ),

      'parent_ID' => array
      (
        'type' => 'option',
        'options' => 'find_all', // ie function of default_model
        'label' => 'Moeder pagina'
      ),

      'menu_priority' => array
      (
        'type' => 'option',
        'options' => range(0,8),
        'default' => 1,
        'label' => 'Menu prioriteit'
      ),

      'content' => array
      (
        'type' => 'text-editor',
        'label' => 'Inhoud'
      ),
      
      'template' => array
      (
        'type' => 'option',
        'options' => get_files('../theme'),
        'default' => 'full.php',
        'label' => 'Template',
        'show-in-overview' => True
      )
    );
  }
}
?>
