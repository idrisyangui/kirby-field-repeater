<?php foreach($field->entries() as $entry): ?>
<div class="structure-entry" id="structure-entry-<?php echo $entry->id() ?>">
  <div class="structure-entry-content text">
    <?php  // echo $field->entry($entry) ?>
    <?php  echo $field->formidable($entry); ?>
    <?php  print_r($entry); ?>
    <?php  // echo $field->update_1($entry); ?>
  </div>
</div>          
<?php endforeach ?>