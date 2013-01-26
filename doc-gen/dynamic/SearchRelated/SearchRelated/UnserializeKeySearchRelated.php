<?php
//////////

/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 key_id unserialize 成 key structure</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: string</li><li>[中文(傳統)] key_id</li></ul>
/// @param [=out] str                                                 <ul><li>type: hash</li><li>[中文(傳統)] key 的 structure, 請參考 search_related 的 key 的部份</li><li>see: dynamic:: SearchRelated.php</li></ul>
/// 
 /// 
//////////
function UnserializeKeySearchRelated(&$str) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelated();
  $result = JsonDecode($str, $columns);

  return $result;
}
?>
