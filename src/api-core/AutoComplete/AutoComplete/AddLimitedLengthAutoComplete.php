<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('AutoComplete/AutoComplete/SerializeKeyAutoComplete.php'); ?>
<?php include_once('AutoComplete/AutoComplete/AddLimitedLengthAutoComplete/AddLimitedLengthAutoCompleteCheckParams.php'); ?>
<?php include_once('AutoComplete/AutoComplete/ParseNewObjAutoComplete.php'); ?>
<?php ?>
<?php include_once('AutoComplete/AutoComplete/GetAutoComplete.php'); ?>
<?php include_once('AutoComplete/AutoComplete/GetCountAutoComplete.php'); ?>
<?php include_once('Length/LengthLimited/LengthLimitedCompileColumn.php'); ?>
<?php include_once('Common/SetData.php'); ?>
<?php include_once('Common/RemoveData.php'); ?>
<?php /* include_once('Common/GetData.php'); */ ?>
<?php /* include_once('Common/MultiGetData.php'); */ ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php /* include_once('Common/RemoveData.php'); */ ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 如果 AutoComplete 本身是有限長度的. 用 AddLimitedLengthAutoComplete 增加到 AutoComplete. 
 * 
/// #### GENERAL REQUIRE
/// 1. params['key_id']/(表示 key 的 id (請參考 dynamic::auto_complete))
/// 2. 除非有在 dynamic::auto_complete 特別說明. 否則 column_name/column_value 裡的 structure 都需要設定. 
/// 2.1. (column_name_id_format 在 api-1 會自動設定. the_timestamp/info 是 optional)
/// 3. 如果 2 沒有辦法提供的話. 可以直接提供 column_name_id/column_value_id
*
* # DO
* 1. 檢查 params (CheckParams)
* 2. 設定 info
* 3. 設定 new_obj. either 是 cols (多個 column_name) . or 是 column_name => column_value.
* 4. 拿到原本的 array. (GetAutoComplete 目前 policy: 因為長度是有限的. 而且是 add. 所以就全拿. (如果太多的話. 要考慮比較好的縮短長度的方法))
* 5. 用 LengthLimitedCompileColumn 找到 add_cols 和 remove_cols
* 6. 如果需要 remove 的話. 就 remove_data.
* 7. 如果需要 add 的話. 就 add data.
* 
* @todo 1. 如果長度太長的話. 要考慮比較好的縮短長度的方法. (其實只要拿小 score 就好了. 最多只會換 new_obj 個 (但是要考慮一樣分數 (要考慮一樣分數的 count 的期望值)) (目前好像是一樣分數就直接換掉. 所以只要拿 n 個就好了. (如果其實想要保留的話. 要調整的是分數.))
*/
function AddLimitedLengthAutoComplete(&$params, $col_start = "", $col_end = "", $ttl = null, $is_check_params = true) {
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
    if($is_check_params && $result_check_params = AddLimitedLengthAutoCompleteCheckParams($params, $result)) {
      $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }
  }
  if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];

  if(isset($params['key_id'])) $key_id = $params['key_id']; else $key_id = SerializeKeyAutoComplete($params);
  $params['key_id'] = $key_id;

  $new_obj = ParseNewObjAutoComplete($params);
  $count_new_obj = count($new_obj);

  $cf_auto_complete = GetCFS('auto_complete', $params);
  if(CheckCFS(array($cf_auto_complete))) {
    $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'CFS');
    return $result;
  }

  $null_ary = array('getter_id' => $params['setter_id']);
  $data_count = GetCountAutoComplete($null_ary, $key_id, null, false, 100 * $NoSQL['MAGIC_LENGTH_LIMITED_MAX_LENGTH_FACTOR'], $col_start, $col_end);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after GetCountAutoComplete: data_count", $data_count);
  $count_auto_complete = $data_count['error'] ? 0 : $data_count['result'];

  $length_to_remove = $count_auto_complete + $count_new_obj - 100;
  $length_to_remove = max($length_to_remove, 0);

  $length_to_get_orig = $length_to_remove + $NoSQL['MAGIC_LENGTH_LIMITED_LENGTH_MIN_OFFSET'];
  $length_to_preserve = $length_to_get_orig + $count_new_obj - $length_to_remove;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "count_auto_complete: $count_auto_complete count_new_obj: $count_new_obj length_to_remove: $length_to_remove length_to_get_orig: $length_to_get_orig length_to_preserve: $length_to_preserve");

  $orig_obj = array();
  if($length_to_get_orig > 0) {
    $params_orig = GetAutoComplete($null_ary, $key_id, null, false, $length_to_get_orig, $col_start, $col_end);
    Debug("INFO", $DEBUG_FILENAME, "after GetAutoComplete: params_orig", $params_orig);
    if($params_orig['error'] != 0 || $params_orig['result'] === null) Debug("WARNINNG", __LINE__ . $DEBUG_FILENAME, "maybe no items: key_id", $key_id);
    else $orig_obj =& $params_orig['result'];
  }
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "orig_obj", $orig_obj);
  $cols = LengthLimitedCompileColumn($new_obj, $orig_obj, $length_to_preserve);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after LengthLimitedCompileColumn: cols", $cols);

  $remove_cols = array_keys($cols['remove_cols']);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to Remove: key_id: $key_id remove_cols", $remove_cols);
  if(!empty($remove_cols) && RemoveData($cf_auto_complete, $key_id, $remove_cols)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'REMOVE');
    return $result;
  }

  $add_cols =& $cols['add_cols'];
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to SetData: key_id: $key_id add_cols", $add_cols);
  if(!empty($add_cols) && SetData($cf_auto_complete, $key_id, $add_cols, $ttl)) {
    $result['error'] = ErrorCode('AUTO_COMPLETE', $function_name, 'CF1');
    return $result;
  }

  return $result;
}

?>
