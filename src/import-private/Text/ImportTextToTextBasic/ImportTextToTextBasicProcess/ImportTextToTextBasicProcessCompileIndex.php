<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCore.php'); ?>
<?php include_once('SearchRelated/SearchRelated/UnserializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeKeySearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnNameSearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnValueSearchRelatedIndex.php'); ?>
<?php ?>
<?php
function ImportTextToTextBasicProcessCompileIndex($rows_compile, $params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($rows_compile as $each_key => &$each_val) {
    $each_key_st = UnserializeKeySearchRelated($each_key);
    $params_compile_index = ImportTextToTextBasicProcessCompileIndexParams($each_key_st, $params);

    $key = SerializeKeySearchRelatedIndex($params_compile_index);
    $column_name = SerializeColumnNameSearchRelatedIndex($params_compile_index);
    $column_value = SerializeColumnValueSearchRelatedIndex($params_compile_index);
  
    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }

  return $rows;
}

function ImportTextToTextBasicProcessCompileIndexIdx($key_st) {
  $sub_string = $key_st['sub_string'];
  $str_len = mb_strlen($sub_string);
  $idx = ($str_len == 1) ? $GLOBALS["SEARCH_RELATED_INDEX_DEFAULT_KEY"] : mb_substr($sub_string, 0, $str_len - 1);

  return $idx;
}

function ImportTextToTextBasicProcessCompileIndexParams($key_st, &$params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $idx = ImportTextToTextBasicProcessCompileIndexIdx($key_st);

  $result = array('prefix' => $key_st['prefix'],
                  'sub_string_idx' => $idx,
                  'column_name_id_format' => '',
                  'the_timestamp' => '',
                  'sub_string' => $key_st['sub_string'],
                  'info' => '');
  return $result;
}
?>
