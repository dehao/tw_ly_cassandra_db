<?php include_once('Common/DeformatJsonBracket.php'); ?>
<?php ?>
<?php
/**********
 * JsonDecode
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function JsonDecode($str) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/php-common/Common/JsonDecode";
  /**********
   * 1.
   */
  if(is_array($str)) {
    assert(false);
    return $str;
  }
  $orig_str = $str;
  $str = DeformatJsonBracket($str);
  //Debug("INFO", $DEBUG_FILENAME, "after DeformatJsonBracket: str", $str);
  $str = json_decode($str, true);
  //if($str === null) $str = $orig_str;
  //Debug("INFO", $DEBUG_FILENAME, "after json_decode: str", $str);
  
  /**********
   * 2. 
   */

  /**********
   * return
   */

  return $str;
}
?>
