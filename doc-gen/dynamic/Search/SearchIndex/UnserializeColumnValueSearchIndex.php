<?php
//////////

/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 + api-2) 將 column_value_id unserialize 成 column_value structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] column_value_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] column_value 的 structure, 請參考 search_index 的 column_value 的部份</li><li>see: dynamic:: SearchIndex.php</li></ul>
/// 
 /// 
//////////
function UnserializeColumnValueSearchIndex(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchIndex();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
