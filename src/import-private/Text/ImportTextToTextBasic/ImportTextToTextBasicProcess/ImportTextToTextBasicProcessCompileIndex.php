<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php ?>
<?php
function ImportTextToTextBasicProcessCompileIndex($rows_compile, $params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($rows_compile as $each_key => &$each_val) {
    $each_key_st = UnserializeKeySearchRelated($each_key);
    
    $sub_string = $each_key_st['sub_string'];
    $str_len = mb_strlen($sub_string);
    $idx = ($str_len == 1) ? $GLOBALS["SEARCH_RELATED_INDEX_DEFAULT_KEY"] : mb_substr($sub_string, 0, $str_len - 1);

    $key = ImportTextToTextBasicProcessCompileIndexKey($each_key_st['prefix'], $idx);
    $column_name = ImportTextToTextBasicProcessCompileIndexColumnName($each_key_st['sub_string'], $params);
    $column_value = ImportTextToTextBasicProcessCompileIndexColumnValue($each_key_st['sub_string'], $params);

    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }

  return $rows;
}

function ImportTextToTextBasicProcessCompileIndexKey($prefix, $idx) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('prefix' => $prefix,
                                       'sub_string_idx' => $idx);
  $result = SerializeKeySearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnName($sub_string, $params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('sub_string' => $sub_string);

  $result = SerializeColumnNameSearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnValue($sub_string, $params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $column_name_id_format = isset($params['column_name_id_format']) ? $params['column_name_id_format'] : "";
  $the_timestamp = isset($params['the_timestamp']) ? $params['the_timestamp'] : "";
  $sub_string = $sub_string;
  
  $params_search_related_index = array('column_name_id_format' => $column_name_id_format,
                                       'the_timestamp' => $the_timestamp,
                                       'sub_string' => $sub_string,
                                       'info' => '');
  $result = SerializeColumnValueSearchRelatedIndex($params_search_related_index);
  return $result;
}
?>
