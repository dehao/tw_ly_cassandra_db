<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/KeyAllColumnsSearchRelatedIndex.php'); ?>
<?php ?>
<?php

function SerializeKeySearchRelatedIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelatedIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
