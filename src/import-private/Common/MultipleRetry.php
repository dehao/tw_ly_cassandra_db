<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function MultipleRetry($function_name, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $the_end_i = $GLOBALS["IMPORT_RETRY"];
  for($i = 0; $i < $GLOBALS["IMPORT_RETRY"]; $i++) {
    $data = $function_name($params);
    if(!$data['error']) {
      $the_end_i = $i;
      break;
    }
    Debug("ERROR_IMPORT", __LINE__ . $DEBUG_FILENAME, "data", $data);
    EchoDebug(true, false);
    usleep($GLOBALS["IMPORT_TIME_USLEEP"]);
  }
  if($the_end_i == $GLOBALS["IMPORT_RETRY"]) {
    Debug("ERROR_IMPORT_RETRY", __LINE__ . $DEBUG_FILENAME, "import failed: function_name: $function_name params", $params);
    EchoDebug(true, false);
  }
  
  $NoSQL["_debug"] = "";

  return;
}
?>
