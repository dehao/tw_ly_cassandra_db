<?php
/**********
 * DeformatJsonBracket
 * @memo 把 $NoSQL['PATTERN_LEFT_BRACKET'], $NoSQL['PATTERN_COMMA'], $NoSQL['PATTERN_RIGHT_BRACKET'] 換成 [,]
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function DeformatJsonBracket($str) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/php-common/Common/DeformatJsonBracket";

  return $str;

  /**********
   * 1.
   */
  $pattern = "/" . $NoSQL['PATTERN_LEFT_BRACKET'] . "/u";
  $str = preg_replace($pattern, "[", $str);
  //Debug("INFO", $DEBUG_FILENAME, "pattern: $pattern after LEFT_BRACKET: str", $str);

  $pattern = "/" . $NoSQL['PATTERN_RIGHT_BRACKET'] . "/u";
  $str = preg_replace($pattern, "]", $str);
  //Debug("INFO", $DEBUG_FILENAME, "pattern: $pattern after RIGHT_BRACKET: str", $str);

  $pattern = "/" . $NoSQL['PATTERN_COMMA'] . "/u";
  $str = preg_replace($pattern, ",", $str);
  //Debug("INFO", $DEBUG_FILENAME, "pattern: $pattern after COMMA: str", $str);

  return $str;
}
?>
