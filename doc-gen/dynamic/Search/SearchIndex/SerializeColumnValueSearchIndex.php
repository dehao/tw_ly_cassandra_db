<?php
//////////

/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] (api-1 only) 將 column_value structure serialize 成 column_value_id</li></ul>
/// 
/// # Params
/// @param [(0)!in] params                                            <ul><li>type: hash</li><li>[中文(傳統)] 所有必要的 parameters, 請參考 search_index 裡的 column_value</li><li>see: dynamic:: SearchIndex.php</li></ul>
/// @param [=out] str                                                 <ul><li>type: string</li><li>[中文(傳統)] column_value_id</li></ul>
/// 
 /// 
//////////
function SerializeColumnValueSearchIndex(&$params) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $columns = ColumnValueAllColumnsSearchIndex();
  $str = JsonEncode($params, $columns);
    
  return $str;
}
?>
