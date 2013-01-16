<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('Common/CommonDynamic/AddCommonDynamic/AddCommonDynamicCheckParams.php'); ?>
<?php include_once('Common/CommonDynamic/AddCommonDynamic/AddCommonDynamicDealWith.php'); ?>
<?php include_once('Common/CommonDynamic/SerializeKeyCommonDynamic.php'); ?>
<?php include_once('Common/CommonDynamic/SerializeColumnNameCommonDynamic.php'); ?>
<?php include_once('Common/CommonDynamic/SerializeColumnValueCommonDynamic.php'); ?>
<?php include_once('Common/SetData.php'); ?>
<?php /* include_once('Common/GetData.php'); */ ?>
<?php /* include_once('Common/MultiGetData.php'); */ ?>
<?php /* include_once('Common/GetIndexedData.php'); */ ?>
<?php /* include_once('Common/RemoveData.php'); */ ?>
<?php ?>
<?php
///////////
/// # MEMO
/// 增加到 common_dynamic
///
/// #### GENERAL REQUIRE
/// 1. params['key_id']/(表示 key 的 id (請參考 dynamic::common_dynamic))
/// 2. 除非有在 dynamic::common_dynamic 特別說明. 否則 column_name/column_value 裡的 structure 都需要設定. 
/// 2.1. (column_name_id_format 在 api-1 會自動設定. the_timestamp/info 是 optional)
/// 3. 如果 2 沒有辦法提供的話. 可以直接提供 column_name_id/column_value_id
///  
/// # DO
/// 1. 如果有設定 cols 的話: 
/// 1.1. 設定 key_id.
/// 1. else
/// 1.1. 設定 the_timestamp
/// 1.2. 檢查 params 是 ok 的. (CheckParams)
/// 1.3. 設定 info
/// 1.4. serialize key/column_name/column_value
/// 2. 設定 CF.
/// 3. 設定 cols. 並且實際對 cassandra SetData
/// 4. 增加時要做的其他事情. (DealWith)
///////////
function AddMultiColsCommonDynamic(&$params, $ttl = null, $is_check_params = true, $is_deal_with = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "ADD_MULTI_COLS";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  $key_id = null;
  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();
    
  //1.2

  if(!isset($params['dynamic_ids'])) {
    $result['error'] = ErrorCode('COMMON_DYNAMIC', $function_name, 'API1_NO_IDS');
    return $result;
  }

  $cols = array();
  $cols_column_name_id_format = array();
  $cols_column_name_id = array();
  foreach($params['dynamic_ids'] as $each_val) {
    $params['dynamic_id'] = $each_val;
    if($is_check_params && $result_check_params = AddCommonDynamicCheckParams($params)) {
      $result['error'] = ErrorCode('COMMON_DYNAMIC', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }
        
    if(!isset($params['info'])) $params['info'] = $NoSQL['DEFAULT_JSON_ARRAY'];
    
    //1.4.
    if(isset($params['key_id'])) $key_id = $params['key_id']; else $key_id = SerializeKeyCommonDynamic($params);
    $params['key_id'] = $key_id;
        
    if(isset($params['column_name_id'])) $column_name_id = $params['column_name_id']; else $column_name_id = SerializeColumnNameCommonDynamic($params);
    $params['column_name_id'] = $column_name_id;
    $params['column_name_id_format'] = FormatKeyString($params['column_name_id']);
    if(isset($params['column_value_id'])) $column_value_id = $params['column_value_id']; else $column_value_id = SerializeColumnValueCommonDynamic($params);
    $params['column_value_id'] = $column_value_id;
    $cols[$column_name_id] = $column_value_id;

    $cols_column_name_id[$each_val] = $column_name_id;
    $cols_column_name_id_format[$each_val] = $params['column_name_id_format'];
  }
  $params['cols'] =& $cols;
        
  //2.
  $cf_common_dynamic = GetCFS('common_dynamic', $params);
  if(CheckCFS(array($cf_common_dynamic))) {
    $result['error'] = ErrorCode('COMMON_DYNAMIC', $function_name, 'CFS');
    return $result;
  }

  //3.
  if(isset($params['cols'])) $cols =& $params['cols'];
  else $cols[$column_name_id] = $column_value_id;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to SetData: key_id: $key_id cols", $cols);
  if(SetData($cf_common_dynamic, $key_id, $cols)) { //設定 common_dynamic1 錯誤.
    $result['error'] = ErrorCode('COMMON_DYNAMIC', $function_name, 'CF1');
    return $result;
  }

  $result['column_name_id_format'] =& $cols_column_name_id_format;
  $result['column_name_id'] =& $cols_column_name_id;

  //4.
  if($is_deal_with && $result_deal_with = AddCommonDynamicDealWith($key_id, $params, $result)) {
    $result['error'] = ErrorCode('COMMON_DYNAMIC', $function_name, 'API1_DEAL_WITH', $result_deal_with);
    return $result;
  }

  /**********
   * return
   */
  return $result;
}
?>
