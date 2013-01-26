<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedCompileLetters.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function SearchCompile($str, $the_line) {
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;
  
  $compile_letters = SearchRelatedCompileLetters($str);
  $result = SearchCompileCore($compile_letters, $the_line);

  return $result;
}

function SearchCompileCore($compile_letters, $the_line) {
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $result = array();
  
  for($i = 1; $i <= $GLOBALS["SUB_STRING_LENGTH"]; $i++) {
    $sub_string = "";
    $context = "";
    foreach($compile_letters as $each_letter) {
      $sub_string = SearchCompileSubString($sub_string, $each_letter, $i);
      $the_row = $the_line;
      $the_row = sprintf("%07d", $the_row);
      $result[] = array('sub_string' => $sub_string, 
                        'context' => $context, 
                        'the_row' => $the_row,
                        'the_col' => '');
    }
  }

  return $result;
}

function SearchCompileSubString($sub_string, $each_letter, $max_length) {
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $str_len = mb_strlen($sub_string);
  if($str_len >= $max_length) $sub_string = mb_substr($sub_string, $str_len - $max_length + 1, $max_length - 1);
  $sub_string .= $each_letter;
  
  return $sub_string;
}

?>
