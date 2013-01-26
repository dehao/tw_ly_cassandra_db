<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/ColumnValueAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function UnserializeColumnValueSearchIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
