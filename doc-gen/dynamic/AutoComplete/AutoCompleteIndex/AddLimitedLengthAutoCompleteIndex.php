<?php
//////////
/// # MEMO
/// 如果 AutoCompleteIndex 本身是有限長度的. 用 AddLimitedLengthAutoCompleteIndex 增加到 AutoCompleteIndex. <br />
/// <br />
/// #### GENERAL REQUIRE<br />
/// 1. params['key_id']/(表示 key 的 id (請參考 dynamic::auto_complete_index))<br />
/// 2. 除非有在 dynamic::auto_complete_index 特別說明. 否則 column_name/column_value 裡的 structure 都需要設定. <br />
/// 2.1. (column_name_id_format 在 api-1 會自動設定. the_timestamp/info 是 optional)<br />
/// 3. 如果 2 沒有辦法提供的話. 可以直接提供 column_name_id/column_value_id<br />
*<br />
*
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] AddLimitedLength</li></ul>
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
 /// 
/// # CheckParams
//////////
function AddLimitedLengthAutoCompleteIndex(&$params, $col_start = "", $col_end = "", $ttl = null, $is_check_params = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "ADD_LIMITED_LENGTH";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  /**********
   * 檢查 params 是 ok 的.
   */
  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();
  if(!isset($params['cols'])) {
    if($is_check_params && $result_check_params = AddLimitedLengthAutoCompleteIndexCheckParams($params, $result)) {
      $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }
  }
  if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];

  if(isset($params['key_id'])) $key_id = $params['key_id']; else $key_id = SerializeKeyAutoCompleteIndex($params);
  $params['key_id'] = $key_id;

  $new_obj = ParseNewObjAutoCompleteIndex($params);
  $count_new_obj = count($new_obj);

  $cf_auto_complete_index = GetCFS('auto_complete_index', $params);
  if(CheckCFS(array($cf_auto_complete_index))) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'CFS');
    return $result;
  }

  $null_ary = array('getter_id' => $params['setter_id']);
  $data_count = GetCountAutoCompleteIndex($null_ary, $key_id, null, false, 100 * $NoSQL['MAGIC_LENGTH_LIMITED_MAX_LENGTH_FACTOR'], $col_start, $col_end);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after GetCountAutoCompleteIndex: data_count", $data_count);
  $count_auto_complete_index = $data_count['error'] ? 0 : $data_count['result'];

  $length_to_remove = $count_auto_complete_index + $count_new_obj - 100;
  $length_to_remove = max($length_to_remove, 0);

  $length_to_get_orig = $length_to_remove + $NoSQL['MAGIC_LENGTH_LIMITED_LENGTH_MIN_OFFSET'];
  $length_to_preserve = $length_to_get_orig + $count_new_obj - $length_to_remove;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "count_auto_complete_index: $count_auto_complete_index count_new_obj: $count_new_obj length_to_remove: $length_to_remove length_to_get_orig: $length_to_get_orig length_to_preserve: $length_to_preserve");

  $orig_obj = array();
  if($length_to_get_orig > 0) {
    $params_orig = GetAutoCompleteIndex($null_ary, $key_id, null, false, $length_to_get_orig, $col_start, $col_end);
    Debug("INFO", $DEBUG_FILENAME, "after GetAutoCompleteIndex: params_orig", $params_orig);
    if($params_orig['error'] != 0 || $params_orig['result'] === null) Debug("WARNINNG", __LINE__ . $DEBUG_FILENAME, "maybe no items: key_id", $key_id);
    else $orig_obj =& $params_orig['result'];
  }
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "orig_obj", $orig_obj);
  $cols = LengthLimitedCompileColumn($new_obj, $orig_obj, $length_to_preserve);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after LengthLimitedCompileColumn: cols", $cols);

  $remove_cols = array_keys($cols['remove_cols']);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to Remove: key_id: $key_id remove_cols", $remove_cols);
  if(!empty($remove_cols) && RemoveData($cf_auto_complete_index, $key_id, $remove_cols)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'REMOVE');
    return $result;
  }

  $add_cols =& $cols['add_cols'];
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to SetData: key_id: $key_id add_cols", $add_cols);
  if(!empty($add_cols) && SetData($cf_auto_complete_index, $key_id, $add_cols, $ttl)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE_INDEX', $function_name, 'CF1');
    return $result;
  }

  return $result;
}
?>
