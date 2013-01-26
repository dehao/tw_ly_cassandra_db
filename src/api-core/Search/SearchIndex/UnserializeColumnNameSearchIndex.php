<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/ColumnNameAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function UnserializeColumnNameSearchIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
