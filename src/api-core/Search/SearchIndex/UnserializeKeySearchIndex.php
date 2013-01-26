<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/KeyAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function UnserializeKeySearchIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
