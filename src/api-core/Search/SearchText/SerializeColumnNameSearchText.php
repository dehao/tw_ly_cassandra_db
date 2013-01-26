<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/ColumnNameAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function SerializeColumnNameSearchText(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchText();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
