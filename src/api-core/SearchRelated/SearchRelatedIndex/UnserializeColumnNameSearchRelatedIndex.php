<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/ColumnNameAllColumnsSearchRelatedIndex.php'); ?>
<?php ?>
<?php

function UnserializeColumnNameSearchRelatedIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchRelatedIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
