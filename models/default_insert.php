<?php

$args = array(
  'model' => $model
);

$form = new insert_form($args);
?>

<h1>Nieuwe <?php echo $model->single; ?></h1>

<form>
<?php echo $form->display(); ?>

<button id='submit' action='insert <?php echo $model->class_name; ?>'>Opslaan</button>
</form>
