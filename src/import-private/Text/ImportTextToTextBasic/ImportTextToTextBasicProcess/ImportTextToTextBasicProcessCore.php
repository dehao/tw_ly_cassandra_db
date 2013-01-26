<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, &$params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : 0;
  $the_row = sprintf($GLOBALS["DIGIT_FORMAT"], $the_row);

  $filename = preg_replace("/\\..*/u", "", $filename); 
  $filename_digit_ary = explode("-", $filename); 

  $score = "";
  $is_first = true;
  foreach($filename_digit_ary as $each_filename_digit) {
    if($is_first) $is_first = false; else $score .= "-";
    $score .= sprintf($GLOBALS["DIGIT_FORMAT"], $each_filename_digit);
  }
  $score .= "-" . $the_row;

  return $score;
}

function ImportTextToTextBasicProcessCompileRows($cf_name_in_file, $params, &$rows) {
  $serialize_key_function = 'SerializeKey' . $cf_name_in_file;
  $serialize_column_name_function = 'SerializeColumnName' . $cf_name_in_file;
  $serialize_column_value_function = 'SerializeColumnValue' . $cf_name_in_file;
  
  $key = $serialize_key_function($params);
  $column_name = $serialize_column_name_function($params);
  $column_value = $serialize_column_value_function($params);

  if(!isset($rows[$key])) $rows[$key] = array();
  $rows[$key][$column_name] = $column_value;
}

function ImportTextToTextBasicProcessTextAry($text) {
  $text_ary = preg_split("/\n/smu", $text); 
  return $text_ary;
}


?>
