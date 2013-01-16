<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Search/Search/SerializeColumnNameSearch.php'); ?>
<?php include_once('Search/Search/SerializeColumnValueSearch.php'); ?>
<?php ?>
<?php
/**********
 *
 */
function ParseNewObjSearch(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $new_obj = array();
  if(isset($params['cols'])) {
    $new_obj = $params['cols'];
  }
  else {
    if(isset($params['column_name_id'])) $column_name_id = $params['column_name_id']; else $column_name_id = SerializeColumnNameSearch($params);
    $params['column_name_id'] = $column_name_id;
    $params['column_name_id_format'] = FormatKeyString($params['column_name_id']);
    if(isset($params['column_value_id'])) $column_value_id = $params['column_value_id']; else $column_value_id = SerializeColumnValueSearch($params);
    $params['column_value_id'] = $column_value_id;
        
    $new_obj[$column_name_id] = $column_value_id;
        
  }
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "new_obj", $new_obj);

  return $new_obj;
}

?>
