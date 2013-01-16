<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * DeformatJsonString
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function DeformatJsonString($input) {
  global $NoSQL;
  $DEBUG_FILENAME = "api/Common/DeformatJsonString";
  /**********
   * 設定 variable
   */
  //Debug("INFO-START", $DEBUG_FILENAME, "input", $input);

  $str_quote = preg_replace("/\\\"/u", "\"", $input);
  //Debug("INFO", $DEBUG_FILENAME, "str_quote", $str_quote);
  $str_slash = preg_replace("/\\\\/u", "\\", $str_quote);
  //Debug("INFO", $DEBUG_FILENAME, "str_slash", $str_slash);
  $result = $str_slash;
  
  return $result;
}
?>
