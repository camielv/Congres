<?php
class member extends default_model
{
  public function __construct($controller)
  {
    $this->controller = $controller;
    $this->class_name = get_class();

    $this->single = 'Lid';
    $this->plural = 'Leden';

    $this->user_permission = array(
      'visible_in_sidebar' => COMMITTEE_MEMBER,
      'overview' => COMMITTEE_MEMBER,
      'insert' => ANY_COMMITTEE_CHAIRPERSON,
      'update' => ANY_COMMITTEE_CHAIRPERSON
    );

    $this->params = array
    (
      'ID' => array
      (
        'type' => 'hidden'
      ),

      'firstname' => array
      (
        'label' => 'Voornaam',
        'show-in-overview' => True
      ),

      'email' => array
      (
        'label' => 'E-mail adres',
        'show-in-overview' => True
      ),

      'hash' => array
      (
        'type' => 'password',
        'on_form_submit' => 'hash_password',
        'label' => 'Wachtwoord'
      )
    );
  }

  public function get_password($id)
  {
    $member = $this->controller->select_by_id($id, $this->class_name);
    return $member['hash'];
  }

  public function hash_password($new_password=False, $id=False)
  {
    if ($new_password)
    {
      //$salt = substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22);
      //return crypt($new_password, '$2a$09$'.$salt);
	  return sha1($new_password);
	}
    else
      return $this->get_password($id);
  }

  public function option_list($selected_member_id='')
  { 
    $list = '<option></option>';
    $members = $this->controller->select_all($this->class_name);
    
    foreach ($members as $member)
    {
      $name = $member['firstname'] . ' ' . $member['tussenvoegsel'] . ' ' . $member['lastname'];
      $list .= sprintf('<option value="%d" %s>%s</option>', $member['ID'], ($member['ID'] === $selected_member_id ? 'selected' : ''), $name);
    }

    return $list;
  }
}
?>
