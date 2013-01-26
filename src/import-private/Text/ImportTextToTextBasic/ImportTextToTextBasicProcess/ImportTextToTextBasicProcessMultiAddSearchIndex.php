<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Search/SearchIndex/MultiAddSearchIndex.php'); ?>
<?php ?>
<?php

function ImportTextToTextBasicProcessMultiAddSearchIndex($rows_search_index) {
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $params = array('rows' => $rows_search_index);

  $the_end_i = $GLOBALS["IMPORT_RETRY"];
  for($i = 0; $i < $GLOBALS["IMPORT_RETRY"]; $i++) {
    $data = MultiAddSearchIndex($params, "", "", null, false, false);
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
