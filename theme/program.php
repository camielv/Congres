<div class='full white rounded'>
  <h1><?php echo $page['title']; ?></h1>
  <p><?php echo $page['content']; ?></p>
<div class="programma">
<table class="boxed">
	<tr>
		<th></th>
		<th>
			Track Human
		</th>
		<th>
			Track IT
		</th>
	</tr>
	<tr>
		<td>
			10:00 - 11:00
		</td>
		<td colspan="2" class="boxed">
			Registratie
		</td>
	</tr>
	<tr>
		<td>
			11:00 - 12:00
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(0, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(1, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			12:00 - 12:15
		</td>
		<td colspan="2" class="boxed">
			Zaalwissel
		</td>
	</tr>
	<tr>
		<td>
			12:15 - 13:15
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(2, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(3, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			13:15 - 14:15
		</td>
		<td colspan="2" class="boxed">
			Lunchpauze
		</td>
	</tr>
	<tr>
		<td>
			14:15 - 15:15
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(4, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(5, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			15:15 - 15:30
		</td>
		<td colspan="2" class="boxed">
			Zaalwissel
		</td>
	</tr>
	<tr>
		<td>
			15:30 - 16:30
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(6, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
		<td class="boxed">
			<?php $speaker = $controller->select_by_priority(7, 'speaker'); ?>
			<a href="<?php echo BASE_URL;?>/page/2/Lineup/<?php echo $speaker['menu_priority'];?>"><?php echo $speaker['subject'];?> (<?php echo $speaker['language'];?>)<br \>
			<?php echo $speaker['speaker']; ?></a>
		</td>
	</tr>
	<tr>
		<td>
			16:30
		</td>
		<td colspan="2" class="boxed">
			Borrel
		</td>
	</tr>
</table>
</div>
</div>
