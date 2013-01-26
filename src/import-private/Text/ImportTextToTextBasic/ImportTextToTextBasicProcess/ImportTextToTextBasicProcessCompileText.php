<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function ImportTextToTextBasicProcessCompileText($compile, $prefix, $filename, $params) {
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
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related = array('prefix' => $prefix,
                                 'sub_string' => $each_compile['sub_string']);
  $result = SerializeKeySearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessCompileTextColumnName($each_compile, $prefix, $filename, &$params) {
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

?>
