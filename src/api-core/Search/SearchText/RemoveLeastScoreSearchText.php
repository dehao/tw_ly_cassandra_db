<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php /* include_once('Search/SearchText/RemoveLeastScoreSearchText/RemoveLeastScoreSearchTextCheckParams.php'); */ ?>
<?php include_once('Search/SearchText/GetSearchText.php'); ?>
<?php include_once('Search/SearchText/RemoveSearchText.php'); ?>
<?php include_once('Common/GetLeastScoreObj.php'); ?>
<?php include_once('Common/LengthLimitedRemoveSameColumnName.php'); ?>
<?php /* include_once('Common/SetData.php'); */ ?>
<?php /* include_once('Common/GetData.php'); */ ?>
<?php /* include_once('Common/MultiGetData.php'); */ ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php ?>
<?php
/**********
 * RemoveLeastScoreSearchText
 * @memo: (對於 RemoveLeastScoreSearchText 的描述)
 *        1. 拿到已存在的 orig_obj
 *        2. 用 GetRemoveObj 拿到要去掉的 obj (remove_obj)
 *        3. 如果要去掉的不是 new_obj: Remove SearchText
 *        4. 傳回被去掉的 obj (remove_obj)
 *        (這個 function 做了哪些步驟)
 *
 * @param key_id                        song_sung 的 key
 * @param new_obj                       song_sung 的 1 個 new obj ( array( [column name] => [column value] ) 有可能是最小 score 的. null => 只比現存的).
 *
 * @cf song_sung                        (如何影響 song_sung)

 * @return result['obj']                被 remove 掉的 obj
 * @return result['error']              error code
 *
 * @TODO: implement 這個 function
 */
function RemoveLeastScoreSearchText($key_id, $length, &$new_obj, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  $cf_search_text = GetCFS('search_text');
  if(CheckCFS(array($cf_search_text))) {
    $result['error'] = 'CFS';
    return $result;
  }

  /**********
   * 設定 cassandra 需要的 variables
   */

  /**********
   * 執行 cassandra 裡的 functions.
   */
  $null_ary = array();
    
  if(!empty($new_obj)) LengthLimitedRemoveSameColumnName($orig_obj_ary, $new_obj, $cf_search_text, $key_id);
  $remove_obj_ary = GetLeastScoreObj($length, $orig_obj_ary, $new_obj);

  foreach($remove_obj_ary as $remove_obj) {
    if($remove_obj !== null && !isset($new_obj[$remove_obj['column_name']])) {
      unset($orig_obj_ary[$remove_obj['column_name']]);
      $result_remove = RemoveSearchText($key_id, array($remove_obj['column_name']));
      if($result_remove['error']) Debug("WARNING-RemoveError", __LINE__ . $DEBUG_FILENAME, "key_id: $key_id remove_obj", $remove_obj);
    }
  }

  /**********
   * return
   */
  $result['remove_obj'] = $remove_obj;
  $result['orig_obj_ary'] = $orig_obj_ary;
  $result['error'] = 0;
  return $result;
}
?>
