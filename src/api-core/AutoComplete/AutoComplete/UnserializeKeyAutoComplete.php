<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * (api-1 only) 把 params (key_id) unserialize 成 key 的 structure. (params 是 key_id 的 string)
 *       
 * # DO
 * 1. 如果只有一個的話. 直接設定傳回.
 * 2. 如果有很多個的話. 
 * 2.1. JsonDecode (把 bracket 變成真的 bracket, 然後做 json_decode)
 * 2.2. assert null
 * 2.3. 設定 structure (對於每個欄位做 DeformatJsonString)
 */

function UnserializeKeyAutoComplete(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    $str_ary = JsonDecode($params);
  assert($str_ary !== null);
  
  $str['prefix'] = DeformatJsonString($str_ary[0]);
  $str['sub_string'] = DeformatJsonString($str_ary[1]);
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
