<?php
//////////
/// # MEMO
/// (api-1 only) 把 params (column_name_id) unserialize 成 column_name 的 structure. (params 是 column_name_id 的 string)<br />
///       <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 column_name_id unserialize 成 column_name structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] column_name_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] column_name 的 structure, 請參考 search_index 的 column_name 的部份</li><li>see: dynamic:: SearchIndex.php</li></ul>
/// 
/// # DO
/// 1. 如果只有一個的話. 直接設定傳回.
/// 2. 如果有很多個的話. 
/// 2.1. JsonDecode (把 bracket 變成真的 bracket, 然後做 json_decode)
/// 2.2. assert null
/// 2.3. 設定 structure (對於每個欄位做 DeformatJsonString)
/// 
//////////
function UnserializeColumnNameSearchIndex(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    $str['sub_string'] = $params;
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
