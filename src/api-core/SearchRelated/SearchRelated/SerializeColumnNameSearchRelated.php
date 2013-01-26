<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/ColumnNameAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function SerializeColumnNameSearchRelated(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchRelated();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
