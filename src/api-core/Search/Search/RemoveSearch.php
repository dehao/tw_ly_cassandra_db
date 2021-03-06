<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Search/Search/GetSearch.php'); ?>
<?php include_once('Search/Search/RemoveSearch/RemoveSearchCheckParams.php'); ?>
<?php include_once('Search/Search/RemoveSearch/RemoveSearchDealWith.php'); ?>
<?php /* include_once('Common/SetData.php'); */ ?>
<?php /* include_once('Common/GetData.php'); */ ?>
<?php /* include_once('Common/MultiGetData.php'); */ ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php include_once('Common/RemoveData.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 從 search 刪除 data (dynamic 是直接刪除)
 * 
 * # DO
 * 1. 檢查 params (CheckParams)
 * 2. 拿到 CF
 * 3. 拿到原本的 data.
 * 4. 把 data remove 掉.
 * 5. 根據 params_orig 可能要處理其他事情 (update count 之類的)
 */
function RemoveSearch(&$params, $key_id, $column_names = null, $params_orig = null, $is_check_params = true, $is_deal_with = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "REMOVE";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  /**********
   * 檢查 params 是 ok 的.
   */

  if(!isset($params['key_id'])) $params['key_id'] = $key_id;
  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();
  assert($params['key_id'] === $key_id);

  if($is_check_params && $result_check_params = RemoveSearchCheckParams($key_id, $column_names, $params, $result)) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
    return $result;
  }

  /**********
   * 設定 variables 
   */
  if($column_names === null) $column_names = Array();

  /**********
   * 設定 cassandra 需要的 column family
   */
  $cf_search = GetCFS('search', $params);
  if(CheckCFS(array($cf_search))) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'CFS');
    return $result;
  }

  /**********
   * 設定 cassandra 需要的 variables
   */

  /**********
   * 執行 cassandra 裡的 functions.
   */
  if($params_orig === null) {
    $params_orig = GetData($cf_search, $key_id, $column_names);
  }

  if(RemoveData($cf_search, $key_id, $column_names)) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'REMOVE');
    return $result;

  }
  if($params_orig === null) {
    $result['error'] = 0;
    return $result;
  }

  /*****
   * 增加或 replace 時要做的其他事情
   */
  if($is_deal_with && $result_deal_with = RemoveSearchDealWith($key_id, $column_names, $params_orig, $result, $params)) {
    $result['error'] = ErrorCode('SEARCH', $function_name, 'API1_DEAL_WITH', $result_deal_with);
    return $result;
  }

  return $result;
}
?>
