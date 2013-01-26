<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/KeyAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function SerializeKeySearchText(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchText();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
