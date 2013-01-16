<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * (api-1 only) 把 params (column_name_id) unserialize 成 column_name 的 structure. (params 是 column_name_id 的 string)
 *       
 * # DO
 * 1. 如果只有一個的話. 直接設定傳回.
 * 2. 如果有很多個的話. 
 * 2.1. JsonDecode (把 bracket 變成真的 bracket, 然後做 json_decode)
 * 2.2. assert null
 * 2.3. 設定 structure (對於每個欄位做 DeformatJsonString)
 */

function UnserializeColumnNameSearch(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    $str_ary = JsonDecode($params);
  assert($str_ary !== null);
  
  $str['score'] = DeformatJsonString($str_ary[0]);
  $str['search_id'] = DeformatJsonString($str_ary[1]);
  $str['the_row'] = DeformatJsonString($str_ary[2]);
  $str['the_col'] = DeformatJsonString($str_ary[3]);
;
    
  /**********
   * 2. 
   */

  /**********
   * return
   */

  Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "str", $str);
  return $str;
}
?>
