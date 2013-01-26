<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/ColumnNameAllColumnsSearchRelatedIndex.php'); ?>
<?php ?>
<?php

function SerializeColumnNameSearchRelatedIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchRelatedIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
