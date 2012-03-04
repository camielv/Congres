<?php
class tickets extends default_model
{
	  public function __construct($controller)
	  {
		$this->controller = $controller;
		$this->class_name = get_class();

    $this->single = 'Kaartje';
    $this->plural = 'Kaartjes';

    $this->user_permission = array(
      'visible_in_sidebar' => BASIC,
      'overview' => BASIC,
      'insert' => BASIC,
      'update' => BASIC
    );

    $this->params = array
    (
	  'ID' => array
	  (
		'label' => 'ID',
		'type' => 'hidden',
	    'show-in-overview' => true
	  ),

	  'ticket_code' => array
      (
        'label' => 'Voorkeurs code'
      ),

      'payment_code' => array
      (
        'label' => 'Bestelnummer',
	    'show-in-overview' => true
      ),

      'date_time' => array
      (
        'label' => 'date_time'
      ),

      'name' => array
      (
        'label' => 'Naam',
		'show-in-overview' => true
      ),

      'slot1' => array
      (
        'label' => 'Slot 1',
		'show-in-overview' => true
      ),

      'slot2' => array
      (
        'label' => 'Slot 2',
		'show-in-overview' => true
      ),

      'slot3' => array
      (
        'label' => 'Slot 3',
		'show-in-overview' => true
      ),

      'slot4' => array
      (
        'label' => 'Slot 4',
		'show-in-overview' => true
      )
    );
  }
}
?>
