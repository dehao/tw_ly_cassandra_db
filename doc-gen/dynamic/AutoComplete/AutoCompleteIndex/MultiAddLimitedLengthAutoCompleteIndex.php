<?php
//////////
/// # MEMO
/// 如果 AutoCompleteIndex 本身是有限長度的. 用 MultiAddLimitedLengthAutoCompleteIndex 將多個 keys 增加到 AutoCompleteIndex. <br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] MultiAddLimitedLength</li></ul>
/// 
/// # Params
/// @param [(0)!in] &$params                                          <ul><li>type: hash</li><li>[中文(傳統)] 請參考 dynamic::auto_complete_index</li><li>see: dynamic:: AutoCompleteIndex.php</li></ul>
/// @param [!in] $params['setter_id']                                 <ul><li>type: string</li><li>[中文(傳統)] $params['setter id']</li><li>see: fixed:: AutoCompleteIndex.php</li></ul>
/// @param [!in] $params['key_id']                                    <ul><li>type: string</li><li>[中文(傳統)] key_id</li></ul>
/// @param [=in] $params['session'] = [not_isset]                     <ul><li>type: string</li><li>[中文(傳統)] $params['session'] = [not isset]</li><li>see: fixed:: AutoCompleteIndex.php</li></ul>
/// @param [(1)=in] $col_start = ""                                   <ul><li>type: string</li><li>[中文(傳統)] 在跟已經存在 auto_complete_index 裡的 column_name 比較(要刪除)的時候. 要從哪裡開始比 (區間裡小的那個)</li></ul>
/// @param [(2)=in] $col_end = ""                                     <ul><li>type: string</li><li>[中文(傳統)] 在跟已經存在 auto_complete_index 裡的 column_name 比較(要刪除)的時候, 比較的結束點 (區間裡大的那個)</li></ul>
/// @param [(3)=in] $ttl = null                                       <ul><li>type: string</li><li>[中文(傳統)] time to live, 目前都是設成 null</li></ul>
/// @param [(4)=in] $is_check_params = true                           <ul><li>type: string</li><li>[中文(傳統)] (api-1 only) 是否要執行 CheckParams</li></ul>
/// @param [=out] error                                               <ul><li>type: string</li><li>[中文(傳統)] error code</li></ul>
/// 
/// # DO
/// 1. 檢查 params (CheckParams)
/// 2. 設定 info
/// 3. 設定 new_obj. either 是 cols (多個 column_name) . or 是 column_name => column_value.
/// 4. 拿到原本的 array. (MultiGetAutoCompleteIndex 目前 policy: 因為長度是有限的. 而且是 add. 所以就全拿. (如果太多的話. 要考慮比較好的縮短長度的方法))
/// 5. 對於每 1 個 key: 
/// 5.1. 用 LengthLimitedCompileColumn 找到 add_cols 和 remove_cols
/// 5.2. 如果需要 remove 的話. 就 remove_data.
/// 6. 如果需要 add 的話. 就 multi_set data.
/// 
/// @todo 1. 如果長度太長的話. 要考慮比較好的縮短長度的方法. (其實只要拿小 score 就好了. 最多只會換 new_obj 個 (但是要考慮一樣分數 (要考慮一樣分數的 count 的期望值)) (目前好像是一樣分數就直接換掉. 所以只要拿 n 個就好了. (如果其實想要保留的話. 要調整的是分數.))
/// 
/// # CheckParams
//////////
function MultiAddLimitedLengthAutoCompleteIndex(&$params, $col_start = "", $col_end = "", $ttl = null, $is_check_params = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "MULTI_ADD_LIMITED_LENGTH";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  /**********
   * 檢查 params 是 ok 的.
   */
  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

  if($is_check_params && $result_check_params = MultiAddLimitedLengthAutoCompleteIndexCheckParams($params, $result)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
    return $result;
  }

  if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];

  /**********
   * 設定 variables 
   */

  $new_obj = ParseNewObjAutoCompleteIndex($params);
  $count_new_obj = count($new_obj);
  Debug("INFO", __FILE__ . $DEBUG_FILENAME, "new_obj", $new_obj);

  /**********
   * 設定 cassandra 需要的 column family
   */
  $cf_auto_complete_index = GetCFS('auto_complete_index', $params);
  if(CheckCFS(array($cf_auto_complete_index))) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'CFS');
    return $result;
  }

  $key_ids =& $params['key_ids'];

  $null_ary = array('getter_id' => $params['setter_id']);
  $data_count = MultiGetCountAutoCompleteIndex($null_ary, $key_ids, null, false, 100 * $NoSQL['MAGIC_LENGTH_LIMITED_MAX_LENGTH_FACTOR'], $col_start, $col_end);
  $count_auto_complete_index = array();
  $max_count = 0;
  if($data_count['error']) {
    foreach($key_ids as $each_key) $count_auto_complete_index[$each_key] = 0;
  }
  else {
    foreach($key_ids as $each_key) {
      $count_auto_complete_index[$each_key] = isset($data_count['result'][$each_key]) ? $data_count['result'][$each_key] : 0;
      $max_count = max($max_count, $count_auto_complete_index[$each_key]);
    }
  }

  $length_to_remove = array();
  $max_length_to_remove = 0;
  foreach($key_ids as $each_key) {
    $length_to_remove[$each_key] = $count_auto_complete_index[$each_key] + $count_new_obj - 100;
    $length_to_remove[$each_key] = max($length_to_remove[$each_key], 0);
    $max_length_to_remove = max($max_length_to_remove, $length_to_remove[$each_key]);
  }

  $max_length_to_get_orig = $max_length_to_remove + $NoSQL['MAGIC_LENGTH_LIMITED_LENGTH_MIN_OFFSET'];

  $orig_obj_ary = array();
  if($max_length_to_get_orig > 0) {
    $params_orig = MultiGetAutoCompleteIndex($null_ary, $key_ids, null, false, $max_length_to_get_orig, $col_start, $col_end);
    Debug("INFO", __FILE__ . $DEBUG_FILENAME, "params_orig", $params_orig);
    if($params_orig['error'] != 0 || $params_orig['result'] === null) Debug("WARNINNG", __LINE__ . $DEBUG_FILENAME, "maybe no items: key_ids", $key_ids);
    else $orig_obj_ary =& $params_orig['result'];
  }

  $add_rows = array();
  $cols = array();
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to foreach: key_ids", $key_ids);
  foreach($key_ids as $each_key) {
    $orig_obj = array();
    if(isset($orig_obj_ary[$each_key]))
      $orig_obj = $orig_obj_ary[$each_key];

    $length_to_preserve = $max_length_to_get_orig + $count_new_obj - $length_to_remove[$each_key];
        
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "in foreach: each_key: $each_key orig_obj", $orig_obj);
    $cols[$each_key] = LengthLimitedCompileColumn($new_obj, $orig_obj, $length_to_preserve);
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "in foreach: after LengthLimitedCompileColumn: each_key: $each_key cols[each_key]", $cols[$each_key]);

    $remove_cols = array_keys($cols[$each_key]['remove_cols']);
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to Remove: each_key: $each_key remove_cols", $remove_cols);
    if(!empty($remove_cols) && RemoveData($cf_auto_complete_index, $each_key, $remove_cols)) {
      Debug("WARNING_REMOVE_DATA", __LINE__ . $DEBUG_FILENAME, "each_key: $each_key remove_cols", $remove_cols);
    }

    $add_rows[$each_key] =& $cols[$each_key]['add_cols'];
  }

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to MultiSetData: add_rows", $add_rows);
  if(!empty($add_rows) && MultiSetData($cf_auto_complete_index, $add_rows, $ttl)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'MULTISET');
    return $result;
  }

  return $result;
}
?>
