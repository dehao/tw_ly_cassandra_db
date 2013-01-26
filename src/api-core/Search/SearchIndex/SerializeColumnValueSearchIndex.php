<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/ColumnValueAllColumnsSearchIndex.php'); ?>
<?php ?>
<?php

function SerializeColumnValueSearchIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
