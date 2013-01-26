<?php
//////////

/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 column_name_id unserialize 成 column_name structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] column_name_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] column_name 的 structure, 請參考 search_text 的 column_name 的部份</li><li>see: dynamic:: SearchText.php</li></ul>
/// 
 /// 
//////////
function UnserializeColumnNameSearchText(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnNameAllColumnsSearchText();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
