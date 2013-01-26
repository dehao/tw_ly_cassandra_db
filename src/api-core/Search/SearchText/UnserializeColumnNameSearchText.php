<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/ColumnNameAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function UnserializeColumnNameSearchText(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchText();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
