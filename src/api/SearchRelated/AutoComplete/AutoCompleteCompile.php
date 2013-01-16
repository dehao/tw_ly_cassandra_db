<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('SearchRelated/SearchRelatedCompileLetters.php'); ?>
<?php
/**********
 * AutoCompleteCompile
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function AutoCompleteCompile($str) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  //key_ids
  $lines = SearchRelatedCompileLetters($str);
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "letters", $letters);

  $result = AutoCompleteCompileCore($lines);

  //Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "result", $result);

  return $result;
}

function AutoCompleteCompileCore($lines) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/api/SearchRelated/AutoComplete/AutoCompleteCompile";

  $result = array();
  $sub_string = "";

  $n_lines = count($lines);
  foreach($lines as $each_idx_line => $each_line) {
    $context = SearchRelatedCompileContext($lines, $each_idx_line);
    foreach($each_line as $each_letter) {
      $sub_string = AutoCompleteCompileSubString($sub_string, $each_letter);
      $result[] = array('sub_string' => $sub_string, 
                        'context' => $context, 
                        'the_row' => $each_idx_line,
                        'the_col' => '');
    }
  }

  //Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "result", $result);

  return $result;
}

function AutoCompleteCompileSubString($sub_string, $each_letter) {
  $str_len = mb_strlen($sub_string);
  if($str_len >= $GLOBALS["SUB_STRING_LENGTH"]) $sub_string = mb_substr($sub_string, $str_len - $GLOBALS["SUB_STRING_LENGTH"] + 1, $GLOBALS["SUB_STRING_LENGTH"] - 1);
  $sub_string .= $each_letter;
  return $sub_string;
}

?>
