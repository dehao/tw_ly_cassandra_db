<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCore.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnNameSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnValueSearchRelated.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function ImportTextToTextBasicProcessCompileText($compile, $prefix, $filename, $params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($compile as $each_compile) {
    $params_compile_text = ImportTextToTextBasicProcessCompileTextParams($each_compile, $prefix, $filename, $params);

    $key = SerializeKeySearchRelated($params_compile_text);
    $column_name = SerializeColumnNameSearchRelated($params_compile_text);
    $column_value = SerializeColumnValueSearchRelated($params_compile_text);
  
    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }
  return $rows;
}

function ImportTextToTextBasicProcessCompileTextParams($each_compile, $prefix, $filename, &$params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $score = ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, $params);
  
  $params_compile_text = array('prefix' => $prefix,
                               'sub_string' => $each_compile['sub_string'],
                               'context' => $each_compile['context'],
                               'search_related_id' => $filename,
                               'the_row' => $each_compile['the_row'],
                               'the_col' => $each_compile['the_col'],
                               'score' => $score,
                               'info' => '');

  return $params_compile_text;
}
?>
