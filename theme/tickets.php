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
        $msgs[] = $this->validateMsg('"Voornaam"',$_POST['firstname'],true,0,255,"^[a-zA-Z' ]+$");
        $msgs[] = $this->validateMsg('"Achternaam"',$_POST['surname'],true,0,255,"^[a-zA-Z' ]+$");
        $msgs[] = $this->validateMsg('"Email"',$_POST['email'],true,0,255,'^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$'); 
        $msgs[] = $this->validateMsg('"Aantal kaartjes"',$_POST['quantity'],true,0,255,'[0-9]+');
        $msgs[] = $this->validateMsg('"U bent"',$_POST['institute'],true,0,255,"^[a-zA-Z' ]+$");
        if (isset($_POST['institute']) && $_POST['institute'] != "") {
		    $values = array('college' => '"Hogeschool"', 'university' => '"Universiteit"', 'company' => '"Bedrijf"', 'other' => '"Anders"');
		    $msgs[] = $this->validateMsg($values[$_POST['institute']],$_POST[$_POST['institute']],true,0,255,"^[a-zA-Z' ]+$");
        }
		if (isset($_POST['via'])) {
		    $msgs[] = $this->validateMsg('"Studentnummer"',$_POST['uvaid'],true,0,255,"^[0-9]+$");
		}
        $msgs[] = $this->validateMsg('"U heeft ons gevonden via"',$_POST['foundus'],true,0,255,"^[a-zA-Z' ]+$");
		if (isset($_POST['comment']) && $_POST['comment'] != "") {
			$msgs[] = $this->validateMsg('"Opmerkingen"',$_POST['comment'],true,0,255,"^[a-zA-Z' ]+$");
		}
        $msgstr = "";
        foreach($msgs as $msg)
            if($msg != "") $msgstr .= ($msgstr==""?"":"<br />"). "Het veld " . $msg;

        $this->msgstr = $msgstr;
        return ($msgstr == "");
	}

    private function validateMsg($label,$value,$nonempty=true,$minChars=0,$maxChars=1000,$regex="") {
        if($nonempty && $value == "") return $label.' mag niet leeg zijn';
        if(strlen($value) < $minChars) return $label.' mag niet meer dan '.$minChars.' karakters hebben';
        if(strlen($value) > $maxChars) return $label.' mag niet minder dan '.$maxChars.' karakters hebben';
        if($regex != "" && preg_match("/$regex/",$value) == 0) return $label.' heeft geen geldig formaat';
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
        $template = "Beste %s %s,\r\n\r\nHierbij bevestigen we uw reservering voor AWESOME IT: The Future Edition.\r\n\r\nNaam: %s %s\r\nAantal kaartjes: %s\r\nVia korting: %s\r\nPrijs: %.2f EURO\r\nOpmerkingen: %s\r\n\r\nMocht er iets niet kloppen, neem dan zo snel mogelijk contact op met congres@svia.nl.\r\n\r\nUw reserveringsnummer is: %s\r\n\r\nAls u het bedrag overmaakt op 9109613 t.n.v. VER INFORMATIEWETENSCH AMSTERDAM, onder vermelding van AWESOME IT en het reserveringsnummer, dan is uw reservering definitief. U ontvangt een bevestiging zodra uw betaling is verwerkt. In deze bevestiging zit tevens het toegangkaartje en de mogelijkheid om per kaartje uw voorkeur voor lezingen uit te spreken.\r\n\r\nMet vriendelijke groet,\r\n\r\n\r\nHet AWESOME IT team\r\ncongres@svia.nl\r\nwww.awesomeit.nl";
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $tickets = (int)$_POST['quantity'];
        $via = ($_POST['via']?'Ja, onder UvAnetID: ' . $_POST['uvaid']:'Nee');
        $price = ((int)$_POST['quantity'])*((float)($_POST['via']?6:7.50));
        $comments = ($_POST['comments']!=""?$_POST['comments']:"Geen");
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
        $subject = "Bevestiging reservering AWESOME IT: The Future Edition";
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
			echo "<h2>Succes</h2><p>U bestelling is geplaatst! Binnen enkele minuten ontvangt u een bevestigingsmail met verdere instructies.";
	} else {
		if( $submit ){
			echo '<p>LET OP! U heeft niet alle verplichte velden correct ingevuld!</p>';
			echo $object->getMessage();
			echo '<p>Voor vragen over bestellingen kunt u contact opnemen met congres@svia.nl.</p>';
		} else {
			echo '<p>' . $page['content'] . '</p>';
		} 
?>

	<div class="reservation">
		<form method="post" action="">
			<legend>Tickets Bestellen (* verplicht)</legend>
			<ul class="formlist">
			<li>
				<label for="firstname">Voornaam*</label>
			<input type="text" name="firstname" value="<?php echo $firstname; ?>" />
			</li>

			<li>
				<label for="surname">Achternaam*</label>
				<input type="text" name="surname" value="<?php echo $surname;?>" />
			</li>

			<li>
				<label for="email">Email*</label>
				<input type="text" name="email" value="<?php echo $email; ?>" />
			</li>

			<li>
				<label for="quanity">Aantal kaartjes* (7,50 Euro per stuk)</label>
				<input type="text" name="quantity" value="<?php echo ($quantity) ? $quantity : '1';?>" />
			</li>

			<li>
				<label for="institute">U bent*</label>
				<select id="institute" onchange="displayOption(this)" name="institute">
<?php 
	$values = array('college' => 'HBO student', 'university' => 'universitair student', 'company' => 'werkend bij een bedrijf', 'other' => 'anders');
	if(in_array($institute, array_keys($values))) {
?>

					<option value="<?php echo $institute;?>"><?php echo $values[$institute];?></option>

<?php
		unset($values[$institute]);
	} else {
?>

					<option value="">Kies uw optie</option>

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
				<label for="university">Universiteit*</label>
				<select name="university">
					<option value="">Kies uw optie</option>
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
				<label for="college">Hogeschool*</label>
				<select name="college">
					<option value="">Kies uw optie</option>
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
				<label for="company">Bedrijfsnaam*</label>
				<input type="text" name="company" />
			</li>

			<li id="other" class="<?php echo ($institute == 'other') ? 'show' : 'hide';?>">
				<label for="other">Anders*</label>
				<input type="text" name="other" />
			</li>

			<li>
				<label for="via">Lid van Studievereniging VIA:</label>
				<input type="checkbox" onchange="toggle('#uvaid')" name="via" <?php echo ($via != "") ? 'checked = "checked"' : '';?> />
			</li>

			<li id="uvaid" class="<?php echo ($via == "") ? 'hide' : 'show';?>">
				<label for="uvaid">Studentnummer (Voor VIA-Leden)</label>
				<input type="text" name="uvaid" value="<?php echo $uvaid;?>" />
			</li>

			<li>
				<label for="foundus">U heeft ons gevonden via:*</label>
				<select name="foundus">

<?php 
	$values = array('poster of flyer', 'studie', 'docenten', 'persoon', 'anders');
	if(in_array($foundus, $values)) {
?>

					<option value="<?php echo $foundus;?>"><?php echo $foundus;?></option>

<?php
		$values = array_diff($values, array($foundus));
	} else {
?>

					<option value="">Kies uw optie</option>

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
				<label for="comment">Opmerkingen</label>
				<input type ="text" name="comment" value="<?php echo $comment;?>">
			</li>

			<li>
				<input name="submit" type="submit" value="Bestel" />
			</li>
		</ul>
	</form>
</div>
<?php
	}
?>
</div>
