<?php
//////////
/// # MEMO
/// (api-1 only) 把 params 裡相對應於 column_value structure 的 params serialize 成 column_value_id<br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 column_value structure serialize 成 column_value_id</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: hash</li><li>[中文(傳統)] 所有必要的 parameters, 請參考 auto_complete_index 裡的 column_value</li><li>see: dynamic:: AutoCompleteIndex.php</li></ul>
/// @param [=out] str                                                 <ul><li>type: string</li><li>[中文(傳統)] column_value_id</li></ul>
/// 
/// # DO
/// 1. assert 都存在.
/// 2. 如果只有一個 params 的話. 直接傳回. 
/// 3. 如果有很多個的話. 對於每個做 FormatJsonString. 然後做成 json array format (不是 json obj format). 然後傳回.
/// 
//////////
function SerializeColumnValueAutoCompleteIndex(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
    assert(isset($params['column_name_id_format']));
  assert(isset($params['the_timestamp']));
  assert(isset($params['sub_string']));
  assert(isset($params['info']));
  $str = "";
  $str .= $NoSQL['LEFT_BRACKET'];
  $str .= "\"" . FormatJsonString($params['column_name_id_format']) . "\"";
  $str .= $NoSQL['COMMA'];
  $str .= "\"" . FormatJsonString($params['the_timestamp']) . "\"";
  $str .= $NoSQL['COMMA'];
  $str .= "\"" . FormatJsonString($params['sub_string']) . "\"";
  $str .= $NoSQL['COMMA'];
  $str .= "\"" . FormatJsonString($params['info']) . "\"";
  $str .= $NoSQL['RIGHT_BRACKET'];
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
