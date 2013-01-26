<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/ColumnValueAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function UnserializeColumnValueSearchRelated(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchRelated();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
