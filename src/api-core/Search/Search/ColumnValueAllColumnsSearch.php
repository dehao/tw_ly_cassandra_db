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

function ColumnValueAllColumnsSearch() {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  $str = array("column_name_id_format", "the_timestamp", "context", "score", "search_id", "the_row", "the_col", "info");
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
