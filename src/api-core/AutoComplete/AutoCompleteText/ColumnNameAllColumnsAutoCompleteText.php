<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 傳回 column_name 的 columns
 * 
 * # DO
 */

function ColumnNameAllColumnsAutoCompleteText() {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  $str = array("score", "text_id", "the_row", "the_col");
;
    
  /**********
   * 2. 
   */

  /**********
   * return
   */

  Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "str", $str);
  return $str;
}
?>
