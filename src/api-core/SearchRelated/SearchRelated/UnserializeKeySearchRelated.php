<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/KeyAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function UnserializeKeySearchRelated(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelated();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
