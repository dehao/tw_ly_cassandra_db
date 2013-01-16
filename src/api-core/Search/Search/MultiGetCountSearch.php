<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Common/MultiGetCount.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 對於多個 keys 算有多少個.
 * 
 * # DO
 * 1. 拿 CF
 * 2. 算 count.
 * 3. 傳回.
 */

function MultiGetCountSearch($params, $key_ids, $cols = null, $is_reverse = true, $max_length = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "MULTI_GET_COUNT";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  if($max_length <= 0) {
    Debug("ERROR_LENGTH", __LINE__ . $DEBUG_FILENAME, "", "max_length: $max_length");
    $result['error'] = ErrorCode('SEARCH', $function_name, 'API1_CHECK_PARAMS', $NoSQL['ERROR_AVAILABLE']);
    return $result;
  }

  $cf_search = GetCFS('search', $params);
  if(CheckCFS(array($cf_search))) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'CFS');
    return $result;
  }

  if($cols === null) $cols = array();
  $data = MultiGetCount($cf_search, $key_ids, $cols, $is_reverse, $max_length, $col_start, $col_end);
  if($data === null) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'MULTIGET_COUNT');
    foreach($key_ids as $each_key)
      $result['result'][$each_key] = 0;
    return $result;
  }
  foreach($key_ids as $each_key)
    if(!isset($data[$each_key])) $data[$each_key] = 0;

  $result['result'] = $data;
  return $result;
}
?>
