<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php /* include_once('Common/SetData.php'); */ ?>
<?php include_once('Common/GetData.php'); ?>
<?php include_once('Common/GetDataRemoveFirstColumnName.php'); ?>
<?php include_once('Search/SearchIndex/GetSearchIndex/GetSearchIndexCheckParams.php'); ?>
<?php /* include_once('Common/MultiGetData.php'); */ ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php /* include_once('Common/RemoveData.php'); */ ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 拿到 SearchIndex (require: params['key_id'])
 * 
 * # DO
 * 1. 設定 column_names/max_length
 * 2. 拿到 CFS
 * 3. 拿到 data. (檢查 data 是在 fixed 那邊做的.)
 */
function GetSearchIndex(&$params, $key_id, $column_names = null, $is_reverse = true, $max_length = LENGTH_GET_DATA, $col_start = "", $col_end = "", $is_with_start = false, $is_check_available = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "GET";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];


  $orig_max_length = $max_length;

  if($max_length <= 0) {
    Debug("ERROR_LENGTH", __LINE__ . $DEBUG_FILENAME, "", "max_length: $max_length");
    $result['error'] = ErrorCode('SEARCH_INDEX', $function_name, 'API1_CHECK_PARAMS', $NoSQL['ERROR_AVAILABLE']);
    return $result;
  }

  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

  if(!isset($NoSQL['IS_GET_LIST_CHECK_AVAILABLE'])) $NoSQL['IS_GET_LIST_CHECK_AVAILABLE'] = false;
  else $is_check_available = $NoSQL['IS_GET_LIST_CHECK_AVAILABLE'];

  if($result_check_params = GetSearchIndexCheckParams($params, $key_id, $column_names, $is_reverse, $max_length, $col_start, $col_end, $is_with_start, $is_check_available, $result)) {
    $result['error'] = ErrorCode('SEARCH_INDEX', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
    return $result;
  }

  /*****
   * 多加 1 個.
   */
  if($col_start !== "" && $is_with_start === false) $max_length++;

  /**********
   * 檢查 params 是 ok 的.
   */
  if($column_names === null) $column_names = Array();
  else $max_length = min($max_length, count($column_names));

  /**********
   * 設定 cassandra 需要的 column family
   */
  $cf_search_index = GetCFS('search_index', $params);
  if(CheckCFS(array($cf_search_index))) {
    $result['error'] = ErrorCode('SEARCH_INDEX', $function_name, 'CFS');
    return $result;
  }

  /**********
   * 設定 cassandra 需要的 variables
   */

  /**********
   * 執行 cassandra 裡的 functions.
   */
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to GetData: key_id: $key_id column_names", $column_names);
  $data = GetData($cf_search_index, $key_id, $column_names, $is_reverse, $max_length, $col_start, $col_end);
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after GetData: data", $data);
  if($data === null) {
    //$result['error'] = ErrorCode('SEARCH_INDEX', $function_name, 'GET');
    //return $result;
    $result['result'] = array();
    return $result;
  }

  if($col_start !== "" && $is_with_start === false) GetDataRemoveFirstColumnName($data, $col_start, $is_with_start, $orig_max_length);
  $result['result'] = $data;
    
  return $result;
}
?>
