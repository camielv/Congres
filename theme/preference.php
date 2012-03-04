<?php
if(strlen($get) > 0 && preg_match("/^[a-z0-9' ]+$/", $get) != 0) {
	$ticket = $controller->select_by_tag('ticket_code', $get, 'tickets');
	if($ticket) {
		$message = "";
		if( $_POST['submit'] ) {
			$ticket['type'] = 'tickets';
			$ticket['date_time'] = time();
			$message = "<p>Status: Uw voorkeuren zijn succesvol opgeslagen!</p>";
			for($i = 1; $i < 5; $i++) {
				if( $_POST['it' . $i] == "on" && $_POST['human' . $i] != "on" ) {
					$ticket['slot' . $i] = 2;
				} else if ( $_POST['it' . $i] != "on" && $_POST['human' . $i] == "on") {
					$ticket['slot' . $i] = 1;
				} else {
					$ticket['slot' . $i] = "";
					$message = "<p>Status: U mag maar 1 lezing per tijdslot selecteren</p>";
				}
			}
			if( isset($_POST['name']) && preg_match("/^[a-zA-Z' ]+$/", $_POST['name']) != 0 ) {
				$ticket['name'] = $_POST['name'];
			}
			$controller->update($ticket);
		}
?>

<div class='full white rounded'>
  <h1><?php echo $page['title']; ?></h1>
  <?php echo $message; ?>
  <p><?php echo $page['content']; ?></p>
<form method="post">
<label for="name">Volledige naam:</label><input class="pref" name="name" type="text" <?php if($ticket['name']) echo "value=\"" . $ticket['name'] . "\"";?>/>
<table class="boxed">
	<tr>
		<th></th><th></th>
		<th>
			Track Human
		</th>
		<th></th>
		<th>
			Track IT
		</th>
	</tr>
	<tr>
		<td>
			11:00 - 12:00
		</td>
		<td>
			<input name="human1" type="checkbox" <?php if($ticket['slot1'] == 1) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(0, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td>
			<input name="it1" type="checkbox" <?php if($ticket['slot1'] == 2) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(1, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			12:15 - 13:15
		</td>
		<td>
			<input name="human2" type="checkbox" <?php if($ticket['slot2'] == 1) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(2, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td>
			<input name="it2" type="checkbox" <?php if($ticket['slot2'] == 2) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(3, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			14:15 - 15:15
		</td>
		<td>
			<input name="human3" type="checkbox" <?php if($ticket['slot3'] == 1) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(4, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td>
			<input name="it3" type="checkbox" <?php if($ticket['slot3'] == 2) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(5, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			15:30 - 16:30
		</td>
		<td>
			<input name="human4" type="checkbox" <?php if($ticket['slot4'] == 1) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(6, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td>
			<input name="it4" type="checkbox" <?php if($ticket['slot4'] == 2) echo "checked";?>/>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(7, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td colspan="5">
			<input name="submit" type="submit" value="Opslaan" />
		</td>
	</tr>
</table>
</form>
</div>

<?php
	} else {
		header('Location: ' . BASE_URL);
	}
} else {
	header('Location: ' . BASE_URL);
}
?>
