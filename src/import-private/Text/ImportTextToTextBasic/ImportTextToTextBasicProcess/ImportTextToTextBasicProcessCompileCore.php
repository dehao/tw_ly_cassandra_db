<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, &$params) {
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
?>
