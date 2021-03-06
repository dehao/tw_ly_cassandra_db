<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Common/GetCount.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 算有多少個.
 * 
 * # DO
 * 1. 拿 CF
 * 2. 算 count.
 * 3. 傳回.
 */

function GetCountAutoCompleteText($params, $key_id, $cols = null, $is_reverse = true, $max_length = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "GET_COUNT";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  if($max_length <= 0) {
    Debug("ERROR_LENGTH", __LINE__ . $DEBUG_FILENAME, "", "max_length: $max_length");
    $result['error'] = ErrorCode('AUTO_COMPLETE_TEXT', $function_name, 'API1_CHECK_PARAMS', $NoSQL['ERROR_AVAILABLE']);
    return $result;
  }

  $cf_auto_complete_text = GetCFS('auto_complete_text', $params);
  if(CheckCFS(array($cf_auto_complete_text))) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_TEXT', $function_name, 'CFS');
    return $result;
  }

  if($cols === null) $cols = array();
  $data = GetCount($cf_auto_complete_text, $key_id, $cols, $is_reverse, $max_length, $col_start, $col_end);
  if($data === null) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_TEXT', $function_name, 'GET_COUNT');
    $result['result'] = 0;
    return $result;
  }

  $result['result'] = $data;
  return $result;
}
?>
