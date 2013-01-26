<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/ColumnNameAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function SerializeColumnNameSearchIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
