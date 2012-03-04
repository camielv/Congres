<?php

$args = array(
  'model' => $model,
  'ID' => $_GET['ID']
);

$form = new update_form($args);
?>

<h1>Update <?php echo $model->single; ?></h1>

<form>
<?php echo $form->display(); ?>

<button id='submit' action='update <?php echo $model->class_name; ?>'>Update</button>
</form>
