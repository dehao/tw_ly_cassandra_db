<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/KeyAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function SerializeKeySearchIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
