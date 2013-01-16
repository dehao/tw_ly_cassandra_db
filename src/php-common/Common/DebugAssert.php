<?php include_once('Common/Debug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function DebugAssert($script, $line, $code) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/php-common/Common/DebugAssert";
  
  Debug("ERROR", $script, "ASSERT: line: $line code", $code);
  return;
}
?>
