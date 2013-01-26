<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function GetDataRemoveFirstColumnName(&$data, $col, $is_with_start, $orig_max_length) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  //Debug("INFO-START", __LINE__ . $DEBUG_FILENAME, "col: $col is_with_start: $is_with_start orig_max_length: $orig_max_length data", $data);
  $to_remove_key = null;

  if($col === "") return;

  
  $keys = array_keys($data);
  $cmp_key = $keys[0];
  settype($cmp_key, gettype($col));
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "col: $col type: " . gettype($col) . " keys[0]: " . $keys[0] . " type: " . gettype($keys[0]) . " cmp_key: $cmp_key");

  if(!$is_with_start && $cmp_key === $col) $to_remove_key = $keys[0];
  else {
    $n_keys = count($keys);
    if($n_keys > $orig_max_length) $to_remove_key = $keys[$n_keys - 1];
  }

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to_remove_key", $to_remove_key);

  if($to_remove_key !== null) unset($data[$to_remove_key]);

  //Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "data", $data);

  return;
}
?>
