<?php
//////////
/// # MEMO
/// 從 search 刪除 data (dynamic 是直接刪除)<br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] Remove</li></ul>
/// 
/// # Params
/// @param [(0)!in] &$params                                          <ul><li>type: hash</li><li>[中文(傳統)] 其他額外的 params, 如果沒有的話. 要傳 array() (而且是在 function 外存在的 variables)</li></ul>
/// @param [!in] $params['setter_id']                                 <ul><li>type: string</li><li>[中文(傳統)] 是誰 remove 的. (for privacy check)</li></ul>
/// @param [=in] $params['session'] = [not_isset]                     <ul><li>type: string</li><li>[中文(傳統)] $params['session'] = [not isset]</li><li>see: fixed:: Search.php</li></ul>
/// @param [(1)!in] key_id                                            <ul><li>type: key</li><li>[中文(傳統)] 要消掉的 key_id</li></ul>
/// @param [(2)=in] column_names = null                               <ul><li>type: array (not json_array)</li><li>[中文(傳統)] 要消掉的 column names (null: 消掉整個 row)</li></ul>
/// @param [(3)=in] params_orig = null                                <ul><li>type: string</li><li>[中文(傳統)] (api-1 only) 原本的 params (null: 會 GetData, "": 不管 params_orig)</li></ul>
/// @param [(4)=in] is_check_params = true                            <ul><li>type: string</li><li>[中文(傳統)] 是否要執行 CheckParams</li></ul>
/// @param [(5)=in] is_deal_with = true                               <ul><li>type: string</li><li>[中文(傳統)] 是否要執行 DealWith</li></ul>
/// @param [=out] error                                               <ul><li>type: string</li><li>[中文(傳統)] error code</li></ul>
/// 
/// # DO
/// 1. 檢查 params (CheckParams)
/// 2. 拿到 CF
/// 3. 拿到原本的 data.
/// 4. 把 data remove 掉.
/// 5. 根據 params_orig 可能要處理其他事情 (update count 之類的)
/// 
/// # CheckParams
/// # DealWith
//////////
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
