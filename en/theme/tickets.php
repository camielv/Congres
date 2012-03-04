<?php
	/*** Variables ***/
	$firstname = $_POST['firstname'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];
	$quantity = $_POST['quantity'];
	$institute = $_POST['institute'];
	$university = $_POST['university'];
	$college = $_POST['college'];
	$company = $_POST['company'];
	$other = $_POST['other'];
	$via = $_POST['via'];
	$uvaid = $_POST['uvaid'];
	$foundus = $_POST['foundus'];
	$comment = $_POST['comment'];
	$submit = $_POST['submit'];

	/*** Functionality ***/

class Ticket extends controller {
	private $msgstr;
	private $ordernr;
	private $code;

	public function submit() {
		if($this->validate()) {
			if($this->storeReservation()){
                $this->sendOrderEmail();
				return true;
			}
		}
		return false;
	}

	public function getMessage() {
		return $this->msgstr;
	}

	private function validate() {
        $msgs = array();
        $msgs[] = $this->validateMsg('"First name"',$_POST['firstname'],true,0,255,"^[a-zA-Z' ]+$");
        $msgs[] = $this->validateMsg('"Surname"',$_POST['surname'],true,0,255,"^[a-zA-Z' ]+$");
        $msgs[] = $this->validateMsg('"Email"',$_POST['email'],true,0,255,'^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$'); 
        $msgs[] = $this->validateMsg('"Quantity tickets"',$_POST['quantity'],true,0,255,'[0-9]+');
        $msgs[] = $this->validateMsg('"You are"',$_POST['institute'],true,0,255,"^[a-zA-Z' ]+$");
        if (isset($_POST['institute']) && $_POST['institute'] != "") {
		    $values = array('college' => '"Hogeschool"', 'university' => '"Universiteit"', 'company' => '"Bedrijf"', 'other' => '"Anders"');
		    $msgs[] = $this->validateMsg($values[$_POST['institute']],$_POST[$_POST['institute']],true,0,255,"^[a-zA-Z' ]+$");
        }
		if (isset($_POST['via'])) {
		    $msgs[] = $this->validateMsg('"Student number"',$_POST['uvaid'],true,0,255,"^[0-9]+$");
		}
        $msgs[] = $this->validateMsg('"Found us via"',$_POST['foundus'],true,0,255,"^[a-zA-Z' ]+$");
		if (isset($_POST['comment']) && $_POST['comment'] != "") {
			$msgs[] = $this->validateMsg('"Comments"',$_POST['comment'],true,0,255,"^[a-zA-Z' ]+$");
		}
        $msgstr = "";
        foreach($msgs as $msg)
            if($msg != "") $msgstr .= ($msgstr==""?"":"<br />"). "The field " . $msg;

        $this->msgstr = $msgstr;
        return ($msgstr == "");
	}

    private function validateMsg($label,$value,$nonempty=true,$minChars=0,$maxChars=1000,$regex="") {
        if($nonempty && $value == "") return $label.' may not be empty';
        if(strlen($value) < $minChars) return $label.' may not contain less than '.$minChars.' characters';
        if(strlen($value) > $maxChars) return $label.' may not contain more than '.$maxChars.' characters';
        if($regex != "" && preg_match("/$regex/",$value) == 0) return $label.' has no valid format';
        return '';
	}	

	private function storeReservation() {
        $query = array();
        $query['first_name'] = $_POST['firstname'];
        $query['surname'] = $_POST['surname'];
        $query['email'] = $_POST['email'];
        $query['quantity'] = (int) $_POST['quantity'];
        $price = ((int)$_POST['quantity'])*((float)($_POST['via']?6:7.50));
        $query['price'] = $price;
        $query['via_id'] = (int)(isset($_POST['via'])?$_POST['uvaid']:0);
        $query['order_timestamp'] = time();
        $query['found_us'] = $_POST['foundus'];
        $query['comments'] = (isset($_POST['comment']))?$_POST['comment'] : 'Geen';
        $query['institute'] = $_POST['institute'];
		$query['institute_value'] = $_POST[$_POST['institute']];
		$query['english'] = '1';
		$query['type'] = 'reservations';
        $this->ordernr = $this->insert($query);
        if($this->ordernr > 0){
            $randomInt = $this->select_by_tag('id', $this->ordernr, 'randomints');
			$this->code = $randomInt['value'];
            if($this->code > 0){
				$query['payment_code'] = $this->code;
				$query['ID'] = $this->ordernr;
				$this->update($query);
                return true;
			}
		}
		return false;
	}
    
	private function sendOrderEmail(){
		$template = "Dear %s %s,\r\n\r\nHereby we confirm your reservation for AWESOME IT: The Future Edition.\r\n\r\nName: %s %s\r\nNumber of tickets: %s\r\nVia discount: %s\r\nPrice: %.2f EURO\r\nComments: %s\r\n\r\nIf there is something wrong with your reservation, please immediately contact congres@svia.nl.\r\n\r\nYour reservation number is: %s\r\n\r\nOnce you have transferred the money to bank account 9109613 in the name of VER INFORMATIEWETENSCH AMSTERDAM, indicated with AWESOME IT and your reservation number, your reservation is definite. You will receive a confirmation mail once your payment has been processed. This confirmation mail contains your entry ticket(s) and the possibility to select your preferences for lectures per ticket\r\n\r\nYours Faithfully,\r\n\r\n\r\nThe AWESOME IT team\r\ncongres@svia.nl\r\nwww.awesomeit.nl/en";
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $tickets = (int)$_POST['quantity'];
        $via = ($_POST['via']?'Yes, with UvAnetID: ' . $_POST['uvaid']:'No');
        $price = ((int)$_POST['quantity'])*((float)($_POST['via']?6:7.50));
        $comments = ($_POST['comments']!=""?$_POST['comments']:"None");
        $body = sprintf(    $template,
                            $firstname,
                            $surname,
                            $firstname,
                            $surname,
                            $tickets,
                            $via,
                            $price,
                            $comments,
                            $this->code
                       );
        $to = $_POST['email'];
        $from = "congres@svia.nl";
        $subject = "Confirmation reservation AWESOME IT: The Future Edition";
        mail($to,$subject,$body,"From: $from");
        mail("camielverschoor@gmail.com","[AWESOMEIT] Bestelling","Zie onderstaande bestelling\r\n\r\n$body","From: $from");
    }
}
?>

<div class='full white rounded'>
	<h1><?php echo $page['title']; ?></h1>

<?php
	$object = new Ticket();
	if( $submit && $object->submit()){
			echo "<h2>Succes</h2><p>Your reservation have been made! In several minute you will receive a confirmation mail containing further instructions.";
	} else {
		if( $submit ){
			echo '<p>WARNING! You have not filled in all required fields</p>';
			echo $object->getMessage();
			echo '<p>For questions about your reservation, please contact congres@svia.nl.</p>';
		} else {
			echo '<p>' . $page['content'] . '</p>';
		} 
?>

	<div class="reservation">
		<form method="post" action="">
			<legend>Order Tickets (* required)</legend>
			<ul class="formlist">
			<li>
				<label for="firstname">First name*</label>
			<input type="text" name="firstname" value="<?php echo $firstname; ?>" />
			</li>

			<li>
				<label for="surname">Surname*</label>
				<input type="text" name="surname" value="<?php echo $surname;?>" />
			</li>

			<li>
				<label for="email">Email*</label>
				<input type="text" name="email" value="<?php echo $email; ?>" />
			</li>

			<li>
				<label for="quanity">Amount of tickets* (7,50 Euro per ticket)</label>
				<input type="text" name="quantity" value="<?php echo ($quantity) ? $quantity : '1';?>" />
			</li>

			<li>
				<label for="institute">You are*</label>
				<select id="institute" onchange="displayOption(this)" name="institute">
<?php 
	$values = array('college' => 'HBO student', 'university' => 'university student', 'company' => 'working for a company', 'other' => 'other');
	if(in_array($institute, array_keys($values))) {
?>

					<option value="<?php echo $institute;?>"><?php echo $values[$institute];?></option>

<?php
		unset($values[$institute]);
	} else {
?>

					<option value="">Choose option</option>

<?php
	}
	foreach(array_keys($values) as $value) {
?>

					<option value="<?php echo $value; ?>"><?php echo $values[$value];?></option>

<?php
	}
?>

				</select>
			</li>

			<li id="university" class="<?php echo ($institute == 'university') ? 'show' : 'hide';?>">	
				<label for="university">University*</label>
				<select name="university">
					<option value="">Choose option</option>
<?php
	$universities = $controller->select_all('universities');
	foreach($universities as $university) {
?>
					<option value="<?php echo $university['name'];?>"><?php echo $university['name'];?></option>
<?php
	}
?>
				</select>
			</li>
			<li id="college" class="<?php echo ($institute == 'college') ? 'show' : 'hide';?>">
				<label for="college">College*</label>
				<select name="college">
					<option value="">Choose option</option>
<?php 
	$colleges = $controller->select_all('colleges');
	foreach($colleges as $college) {
?>

					<option value="<?php echo $college['name'];?>"><?php echo $college['name'];?></option>

<?php
	}
?>

				</select>
			</li>

			<li id="company" class="<?php echo ($institute == 'company') ? 'show' : 'hide';?>">
				<label for="company">Company*</label>
				<input type="text" name="company" />
			</li>

			<li id="other" class="<?php echo ($institute == 'other') ? 'show' : 'hide';?>">
				<label for="other">Other*</label>
				<input type="text" name="other" />
			</li>

			<li>
				<label for="via">Member of study society VIA:</label>
				<input type="checkbox" onchange="toggle('#uvaid')" name="via" <?php echo ($via != "") ? 'checked = "checked"' : '';?> />
			</li>

			<li id="uvaid" class="<?php echo ($via == "") ? 'hide' : 'show';?>">
				<label for="uvaid">Studentnummer (For VIA members)</label>
				<input type="text" name="uvaid" value="<?php echo $uvaid;?>" />
			</li>

			<li>
				<label for="foundus">Found us via:*</label>
				<select name="foundus">

<?php 
	$values = array('poster or flyer', 'education', 'teachers', 'person', 'other');
	if(in_array($foundus, $values)) {
?>

					<option value="<?php echo $foundus;?>"><?php echo $foundus;?></option>

<?php
		$values = array_diff($values, array($foundus));
	} else {
?>

					<option value="">Choose option</option>

<?php
	}
	foreach($values as $value) {
?>

					<option value="<?php echo $value; ?>"><?php echo $value;?></option>

<?php
	 }
?>

				</select>
			<li>
				<label for="comment">Comments</label>
				<input type ="text" name="comment" value="<?php echo $comment;?>">
			</li>

			<li>
				<input name="submit" type="submit" value="Order" />
			</li>
		</ul>
	</form>
</div>
<?php
	}
?>
</div>
