<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelated/KeyAllColumnsSearchRelated.php'); ?>
<?php ?>
<?php

function SerializeKeySearchRelated(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelated();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
