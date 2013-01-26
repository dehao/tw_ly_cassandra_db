<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/ColumnValueAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function SerializeColumnValueSearchRelated(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchRelated();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
