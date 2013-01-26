<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/KeyAllColumnsSearchRelatedIndex.php'); ?>
<?php ?>
<?php

function UnserializeKeySearchRelatedIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelatedIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
