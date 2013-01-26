<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/ColumnNameAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function UnserializeColumnNameSearchRelated(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchRelated();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
