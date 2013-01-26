<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/ColumnValueAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function SerializeColumnValueSearchText(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchText();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
