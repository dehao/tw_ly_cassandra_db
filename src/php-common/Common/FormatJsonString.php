<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * FormatJsonString
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function FormatJsonString($input) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;
  /**********
   * 設定 variable
   */
  //Debug("INFO-START", $DEBUG_FILENAME, "input", $input);
  $input = preg_replace("/\\\\/u", "\\\\\\\\", $input);
  //Debug("INFO-START", $DEBUG_FILENAME, "after 2 -> 4 backslash: input", $input);

  $input = preg_replace("/\"/u", "\\\"", $input);
  $input = preg_replace("/\n/u", "\\n", $input);
  $input = preg_replace("/\x1b/u", "\\u001b", $input);

  $result = $input;
  
  /**********
   * 執行
   */

  /**********
   * return
   */
  //Debug("INFO-END", $DEBUG_FILENAME, "result", $result);
  

  return $result;
}
?>
