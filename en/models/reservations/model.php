<?php
class reservations extends default_model
{
	  public function __construct($controller)
	  {
		$this->controller = $controller;
		$this->class_name = get_class();

    $this->single = 'Reservering';
    $this->plural = 'Reserveringen';

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
        'type' => 'hidden'
      ),

      'first_name' => array
      (
		'label' => 'Voornaam',
		'show-in-overview' => true
      ),

      'surname' => array
      (
        'label' => 'Achternaam',
		'show-in-overview' => true
      ),

      'email' => array
      (
        'label' => 'Email'
      ),

      'quantity' => array
      (
        'label' => 'Aantal kaarten',
		'show-in-overview' => true
      ),

      'price' => array
      (
        'label' => 'Prijs'
      ),

      'via_id' => array
      (
        'label' => 'VIA ID'
      ),

      'order_timestamp' => array
      (
        'label' => 'Datum reservering'
      ),

      'pay_timestamp' => array
      (
        'label' => 'Datum betaling'
      ),

      'confirmed_timestamp' => array
      (
        'label' => 'Betaald',
		'show-in-overview' => true
      ),

      'payment_code' => array
      (
		'type' => 'hidden',
        'label' => 'Bestelnummer',
		'show-in-overview' => true
      ),

      'found_us' => array
      (
        'label' => 'Gevonden door'
      ),

      'comments' => array
      (
        'label' => 'Opmerkingen'
      ),

      'institute' => array
      (
        'label' => 'Type instituut'
      ),

      'institute_value' => array
      (
        'label' => 'Naam instituut'
      ),

      'english' => array
      (
        'label' => 'Engels'
      ),

      'reminder' => array
      (
        'label' => 'Herinneringen'
	  ),

      'ticket' => array
      (
        'label' => 'Ticket',
		'show-in-overview' => true
      )
    );
  }
}
?>
