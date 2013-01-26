<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/ColumnValueAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function UnserializeColumnValueSearchText(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchText();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
