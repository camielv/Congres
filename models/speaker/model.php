<?php
class speaker extends default_model
{
	  public function __construct($controller)
	  {
		$this->controller = $controller;
		$this->class_name = get_class();

    $this->single = 'Spreker';
    $this->plural = 'Sprekers';

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

      'speaker' => array
      (
        'label' => 'Spreker',
        'show-in-overview' => True
      ),

      'subject' => array
      (
        'label' => 'Onderwerp',
        'show-in-overview' => True
      ),
	
	  'description' => array
      (
        'type' => 'textarea',
        'label' => 'Omschrijving'
      ),

      'language' => array
      (
        'label' => 'Taal',
        'show-in-overview' => True
      ),
	  
	  'menu_priority' => array
      (
        'type' => 'option',
        'options' => range(0,8),
        'default' => 1,
        'label' => 'Prioriteit',
	    'show-in-overview' => True
	  ),

      'image' => array
      (
        'label' => 'URL plaatje',
      ),
	
      'videotype' => array
      (
        'label' => 'Type video',
      ),

      'video' => array
      (
        'label' => 'URL video',
      ),

      'website' => array
      (
        'label' => 'Website',
      )
    );
  }
}
?>
