<?php
$speakers = $controller->select_all_with_order('speaker_en', 'menu_priority');
?>
<div id='speakers' class='pagemenu'>
<ul id='speakernav'>
<?php
foreach($speakers as $speaker) {
?>
<li>
	<b><a onClick="showItem('<?php echo $speaker['menu_priority'];?>');">
	<?php echo $speaker['speaker'];?> (<?php echo $speaker['language'];?>)</a></b>
    <br \>
	<?php echo $speaker['subject'];?>
</li>
<?php } ?>
<ul>
</div>
<div id='description' class='pagecontent'>
<?php
	for($i = 0; $i < count($speakers); $i++) {
		if($i == $get || ($i == 0 && ( !(is_numeric($get)) || $get > 7 || $get < 0 ) )) {
			echo '<div id="speaker' . $speakers[$i]['menu_priority'] .'" class="show">';
		} else {
			echo '<div id="speaker' . $speakers[$i]['menu_priority'] .'" class="hide">';
		}
?>
	<h1><?php echo $speakers[$i]['speaker'];?> (<?php echo $speakers[$i]['language'];?>)</h1>
<?php
		if( $speakers[$i]['image'] != "" ) {
?>
	<img class="speakerimage" src="<?php echo BASE_URL . $speakers[$i]['image'];?>" alt="<?php echo $speakers[$i]['speaker'];?>">
<?php
		}
?>
	<h2><?php echo $speakers[$i]['subject'];?></h2>
<?php
		if( $speakers[$i]['website'] != "" ) {
?>
	<p><b>Website: </b><a target="_blank" href="<?php echo $speakers[$i]['website'];?>"><?php echo $speakers[$i]['website'];?></a>
<?php
		}
?>
	<p><?php echo $speakers[$i]['description']?></p>
<?php
		  if( $speakers[$i]['video'] != "") {
?>
    <h2>Video</h2>
<?php
			switch( (int) $speakers[$i]['videotype'] ) {
				case 1:
?>
					<iframe width="335" height="200" src="<?php echo $speakers[$i]['video'];?>" frameborder="0" allowfullscreen></iframe> 
<?php
					break;
				case 2:
					echo $speakers[$i]['video'];
					break;
				default:
					break;
			}
		}
?>
    </div>
<?php
	}
?>

</div>
