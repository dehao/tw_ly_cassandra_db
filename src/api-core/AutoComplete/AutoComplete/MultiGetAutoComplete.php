<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php /* include_once('AutoComplete/AutoComplete/MultiGetAutoComplete/MultiGetAutoCompleteCheckParams.php'); */ ?>
<?php /* include_once('Common/SetData.php'); */ ?>
<?php /* include_once('Common/GetData.php'); */ ?>
<?php include_once('Common/MultiGetData.php'); ?>
<?php include_once('Common/GetDataRemoveFirstColumnName.php'); ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php /* include_once('Common/RemoveData.php'); */ ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 多個 key_ids 拿到 data
 * 
 * # DO
 * 1. 設定 column_names/max_length
 * 2. 拿到 CF
 * 3. MultiGetData.
 */
function MultiGetAutoComplete(&$params, &$key_ids, $column_names = null, $is_reverse = true, $max_length = LENGTH_GET_DATA, $col_start = "", $col_end = "", $is_with_start = false) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 檢查 params 是 ok 的.
   */
  $result = array("error" => 0);
  $function_name = "MULTI_GET";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  $orig_max_length = $max_length;

  if($max_length <= 0) {
    Debug("ERROR_LENGTH", __LINE__ . $DEBUG_FILENAME, "", "max_length: $max_length");
    $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'API1_CHECK_PARAMS', $NoSQL['ERROR_AVAILABLE']);
    return $result;
  }

  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

  /*****
   * 多加 1 個.
   */
  if($col_start !== "" && $is_with_start === false) $max_length++;

  /**********
   * 設定 variables 
   */
  if($column_names === null) $column_names= Array();
  else $max_length = min($max_length, count($column_names));

  /**********
   * 設定 cassandra 需要的 column family
   */
  $cf_auto_complete = GetCFS('auto_complete', $params);
  if(CheckCFS(array($cf_auto_complete))) {
    $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'CFS');
    return $result;
  }

  /**********
   * 設定 cassandra 需要的 variables
   */

  /**********
   * 執行 cassandra 裡的 functions.
   */
  $data = MultiGetData($cf_auto_complete, $key_ids, $column_names, $is_reverse, $max_length, $col_start, $col_end);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after MultiGetData: data", $data);
  if($data === null) {
    //$result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'MULTIGET');
    //return $result;
    $result['result'] = array();
    return $result;
  }
  if($col_start !== "" && $is_with_start === false) {
    foreach($data as $each_data_key => $each_data_cols) {
      GetDataRemoveFirstColumnName($each_data_cols, $col_start, $is_with_start, $orig_max_length);
    }
  }

  $result['result'] = $data;
    
  return $result;
}
?>
