<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchText/KeyAllColumnsSearchText.php'); ?>
<?php ?>
<?php

function UnserializeKeySearchText(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchText();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
