<?php
/*
  
  Default overview / table file.

  This overview will be displaying everything based on the given model
  you can overload this by creating your own overview.php in the model folder
  if you like the table

*/

  $table_head   = table::get_show_in_overview_labels($model->params);
  $table_head[] = ''; // i.e empty for options;

  $rows = $model->find_all();
?>

<h3>Een overzicht van <?php echo $model->plural; ?></h3>

<table class='sortable_table'>
  <tr class='table-head'>
    <?php echo table::create_row($table_head); ?>
  </tr>

  <?php 
    foreach ($rows as $row) : 
      
      /*
      
        First remove data from the row array which isn't required (i.e if the
        model its attribute doesn't have show-in-overview enabled. Then add
        a simple option field to the row so anyone can easily show / edit or
        delete the item (if a member has enough rights to do so).

      */
      $ID  = $row['ID'];
      $row = array_intersect_key($row, $table_head);

  ?>
  <tr>
    <?php echo table::create_row($row); ?>

    <td class='options'>
      <a class='show' href="<?php echo BASE_URL.'/'.$model->class_name.'/'.$ID.'/'.clean(array_shift($row)); ?>">Toon</a>
      <a class='edit' href="?model=<?php echo $model->class_name; ?>&ID=<?php echo $ID; ?>&view=update">Aanpassen</a>
      <a class="delete" href="" model="<?php echo $model->class_name; ?>" id="<?php echo $ID; ?>">Verwijderen</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>