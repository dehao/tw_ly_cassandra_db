<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function SearchRelatedCompileLetters($str) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $str = strtolower($str);
  /*
    $str = htmlspecialchars_decode($str, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES);
    $str = html_entity_decode($str, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, "UTF-8");
    $str = br2nl($str);
  */

  $lines = preg_split("/\n/u", $str);
  $orig_lines = $lines;
  
  foreach($lines as &$each_line) {
    $each_line_purify = preg_replace("/\s+/u", "", $each_line);
    $each_line_purify = preg_replace("/[ ˋ[:punct:]\p{P}\p{S}\p{Z}\p{C}]/u", "", $each_line_purify);

    $each_line_purify = trim($each_line_purify);

    $each_line = $each_line_purify === "" ? array() : preg_split('/(?<!^)(?!$)/u', $each_line_purify);
  }

  $result = array('lines' => $lines,
                  'orig_lines' => $orig_lines);

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "result", $result);
  //EchoDebug();

  return $result;
}

function SearchRelatedCompileContext(&$lines, $idx) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  //Debug("INFO-START", __LINE__ . $DEBUG_FILENAME, "lines", $lines);
  $NoSQL["_debug"] = "";
  //EchoDebug();

  $n_lines = count($lines);
  $start_idx = max($idx - $GLOBALS["SEARCH_RELATED_CONTEXT_N_PREFIX"], 0);
  $end_idx = min($start_idx + $GLOBALS["SEARCH_RELATED_CONTEXT_LINES"], $n_lines);
  $start_idx = max($end_idx - $GLOBALS["SEARCH_RELATED_CONTEXT_LINES"], 0);

  $the_context = "";
  for($i = $start_idx; $i < $end_idx; $i++)
    $the_context .= $lines[$i] . "\n";

  return $the_context;
}

function SearchRelatedCompileSubStringAry($sub_string) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $sub_string_ary = $sub_string === "" ? array() : preg_split('/(?<!^)(?!$)/u', $sub_string);

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "sub_string: $sub_string sub_string_ary", $sub_string_ary);
  //EchoDebug();

  $result = array();

  $the_string = "";
  foreach($sub_string_ary as $each_char) {
    $the_string .= $each_char;
    $result[] = $the_string;
  }

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "result", $result);
  //EchoDebug();

  return $result;
}

?>
