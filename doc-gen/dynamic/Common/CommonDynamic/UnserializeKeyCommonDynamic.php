<?php
//////////
/// # MEMO
/// (api-1 only) 把 params (key_id) unserialize 成 key 的 structure. (params 是 key_id 的 string)<br />
///       <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 key_id unserialize 成 key structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] key_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] key 的 structure, 請參考 common_dynamic 的 key 的部份</li><li>see: dynamic:: CommonDynamic.php</li></ul>
/// 
/// # DO
/// 1. 如果只有一個的話. 直接設定傳回.
/// 2. 如果有很多個的話. 
/// 2.1. JsonDecode (把 bracket 變成真的 bracket, 然後做 json_decode)
/// 2.2. assert null
/// 2.3. 設定 structure (對於每個欄位做 DeformatJsonString)
/// 
//////////
function UnserializeKeyCommonDynamic(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    $str_ary = JsonDecode($params);
  assert($str_ary !== null);
  
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
