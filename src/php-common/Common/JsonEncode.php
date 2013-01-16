<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * JsonEncode
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function JsonEncode($input, $is_array = true, $level = 0, $is_format_json_string = false) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  if($level == 0 && !is_array($input)) {
    Debug("WARNING", __LINE__ . $DEBUG_FILENAME, "", "level 0 input: $input is not array");
    $input = array(0 => $input);
  }

  $str = ($is_array && is_array($input)) ? json_encode(array_values($input), JSON_UNESCAPED_UNICODE) : json_encode($input, JSON_UNESCAPED_UNICODE);
  return $str;

}
?>
