<?php
//////////

/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 key structure serialize 成 key_id</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: hash</li><li>[中文(傳統)] 所有必要的 parameters, 請參考 search_related_index 裡的 key</li><li>see: dynamic:: SearchRelatedIndex.php</li></ul>
/// @param [=out] str                                                 <ul><li>type: string</li><li>[中文(傳統)] key_id</li></ul>
/// 
 /// 
//////////
function SerializeKeySearchRelatedIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = KeyAllColumnsSearchRelatedIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
