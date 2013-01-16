<?php
//////////
/// # MEMO
/// 把 params (column_value_id) unserialize 成 column_value 的 structure. (params 是 column_value_id 的 string)<br />
///       <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 + api-2) 將 column_value_id unserialize 成 column_value structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] column_value_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] column_value 的 structure, 請參考 search_text 的 column_value 的部份</li><li>see: dynamic:: SearchText.php</li></ul>
/// 
/// # DO
/// 1. 如果只有一個的話. 直接設定傳回.
/// 2. 如果有很多個的話. 
/// 2.1. JsonDecode (把 bracket 變成真的 bracket, 然後做 json_decode)
/// 2.2. assert null
/// 2.3. 設定 structure (對於每個欄位做 DeformatJsonString)
/// 
//////////
function UnserializeColumnValueSearchText(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    $str_ary = JsonDecode($params);
  assert($str_ary !== null);
  
  $str['column_name_id_format'] = DeformatJsonString($str_ary[0]);
  $str['the_timestamp'] = DeformatJsonString($str_ary[1]);
  $str['context'] = DeformatJsonString($str_ary[2]);
  $str['score'] = DeformatJsonString($str_ary[3]);
  $str['text_id'] = DeformatJsonString($str_ary[4]);
  $str['the_row'] = DeformatJsonString($str_ary[5]);
  $str['the_col'] = DeformatJsonString($str_ary[6]);
  $str['info'] = DeformatJsonString($str_ary[7]);
;

  /**********
   * 2. 
   */

  /**********
   * return
   */

  //Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "str", $str);
  return $str;
}
?>
