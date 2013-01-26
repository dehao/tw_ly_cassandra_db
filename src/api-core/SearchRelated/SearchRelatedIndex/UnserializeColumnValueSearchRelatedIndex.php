<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/ColumnValueAllColumnsSearchRelatedIndex.php'); ?>
<?php ?>
<?php

function UnserializeColumnValueSearchRelatedIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchRelatedIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
