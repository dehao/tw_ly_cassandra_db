<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/AutoComplete/AutoCompleteCompile.php'); ?>
<?php include_once('AutoComplete/AutoCompleteText/MultiAddAutoCompleteText.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/MultiAddAutoCompleteIndex.php'); ?>
<?php include_once('SearchRelated/Search/SearchCompile.php'); ?>
<?php include_once('Search/SearchText/MultiAddSearchText.php'); ?>
<?php include_once('Search/SearchIndex/MultiAddSearchIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/UnserializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnNameSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnValueSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeKeySearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnNameSearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnValueSearchRelatedIndex.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextToTextBasicProcess
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param 
 *
 * @return 
 * 
 * @TODO (這個 function 的 todo)
 */

function ImportTextToTextBasicProcess(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $NoSQL["DEBUG"] = false;
  $params['filename'] = basename($params['filename']);

  $prefix = $params['prefix'];
  $text = $params['text'];
  $filename = $params['filename'];

  $text_ary = ImportTextToTextBasicProcessTextAry($text);

  foreach($text_ary as $each_text_line => $each_text) {
    $search_compile = SearchCompile($the_text, $each_text_line);
    if(empty($search_compile)) continue;
    $rows_compile = ImportTextToTextBasicProcessCompileText($search_compile, $prefix, $filename, $params, $each_text_line);
    
    $params_search_text = array('rows' => $rows_compile);
    MultipleRetry("MultiAddSearchText", $params_search_text);
    
    $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile, $params);
    
    $params_search_index = array('rows' => $rows_index_compile);
    MultipleRetry("MultiAddSearchIndex", $params_search_index);
  }

  return 0;
}

function ImportTextToTextBasicProcessCompileText($compile, $prefix, $filename, $params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($compile as $each_compile) {
    $key = ImportTextToTextBasicProcessCompileTextKey($each_compile, $prefix, $params);
    $column_name = ImportTextToTextBasicProcessCompileTextColumnName($each_compile, $prefix, $filename, $params);
    $column_value = ImportTextToTextBasicProcessCompileTextColumnValue($each_compile, $prefix, $filename, $params);
    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }
  return $rows;
}

function ImportTextToTextBasicProcessCompileTextKey($each_compile, $prefix, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related = array('prefix' => $prefix,
                                 'sub_string' => $each_compile['sub_string']);
  $result = SerializeKeySearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessCompileTextColumnName($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $search_related_id = $filename;
  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : "";
  $the_col = isset($each_compile['the_col']) ? $each_compile['the_col'] : "";
  $score = ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, $params);
  $params_search_related = array('search_related_id' => $search_related_id,
                                 'the_row' => $the_row,
                                 'the_col' => $the_col,
                                 'score' => $score
    );
  $result = SerializeColumnNameSearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessCompileTextColumnValue($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;
  
  $column_name_id_format = isset($params['column_name_id_format']) ? $params['column_name_id_format'] : "";
  $the_timestamp = isset($params['the_timestamp']) ? $params['the_timestamp'] : "";
  $context = isset($each_compile['context']) ? $each_compile['context'] : "";
  $search_related_id = $filename;
  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : "";
  $the_col = isset($each_compile['the_col']) ? $each_compile['the_col'] : "";
  $score = ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, $params);
  
  $params_search_related = array('column_name_id_format' => $column_name_id_format,
                                 'the_timestamp' => $the_timestamp,
                                 'context' => $context,
                                 'search_related_id' => $search_related_id,
                                 'the_row' => $the_row,
                                 'the_col' => $the_col,
                                 'score' => $score,
                                 'info' => '');
  $result = SerializeColumnValueSearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : 0;
  $the_row = sprintf("%04d", $the_row);

  $filename = preg_replace("/\\..*/u", "", $filename); 
  $filename_digit_ary = preg_split("/-/u", $filename); 

  $score = "";
  $is_first = true;
  foreach($filename_digit_ary as $each_filename_digit) {
    if($is_first) $is_first = false; else $score .= "-";
    $score .= sprintf("%04d", $each_filename_digit);
  }
  $score .= "-" . $the_row;

  return $score;
}

function ImportTextToTextBasicProcessCompileIndex($rows_compile, $params) {
  global $NoSQL;
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
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('prefix' => $prefix,
                                       'sub_string_idx' => $idx);
  $result = SerializeKeySearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnName($sub_string, $params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('sub_string' => $sub_string);

  $result = SerializeColumnNameSearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnValue($sub_string, $params) {
  global $NoSQL;
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

function ImportTextToTextBasicProcessTextAry($text) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $text_ary = preg_split("/\n/smu", $text);
  return $text_ary;
}

?>
