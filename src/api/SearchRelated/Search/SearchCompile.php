<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('SearchRelated/SearchRelatedCompileLetters.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function SearchCompile($str, $the_start_line) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;
  
  //key_ids
  $result_compile_letters = SearchRelatedCompileLetters($str);
  $orig_lines = $result_compile_letters['orig_lines'];
  $lines = $result_compile_letters['lines'];
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "lines", $lines);

  $result = SearchCompileCore($lines, $orig_lines, $the_start_line);

  return $result;
}

function SearchCompileCore($lines, $orig_lines, $the_start_line) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $result = array();
  
  for($i = 1; $i <= $GLOBALS["SUB_STRING_LENGTH"]; $i++) {
    $sub_string = "";
    
    $n_lines = count($lines);
    foreach($lines as $each_idx_line => $each_line) {
      //$context = SearchRelatedCompileContext($orig_lines, $each_idx_line);
      $context = "";
      foreach($each_line as $each_letter) {
        $sub_string = SearchCompileSubString($sub_string, $each_letter, $i);
        $the_row = $each_idx_line + $the_start_line;
        $the_row = sprintf("%07d", $the_row);
        $result[] = array('sub_string' => $sub_string, 
                          'context' => $context, 
                          'the_row' => $the_row,
                          'the_col' => '');
      }
    }
  }

  //Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "result", $result);
  return $result;
}

function SearchCompileSubString($sub_string, $each_letter, $max_length) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $str_len = mb_strlen($sub_string);
  if($str_len >= $max_length) $sub_string = mb_substr($sub_string, $str_len - $max_length + 1, $max_length - 1);
  $sub_string .= $each_letter;
  
  return $sub_string;
}

?>