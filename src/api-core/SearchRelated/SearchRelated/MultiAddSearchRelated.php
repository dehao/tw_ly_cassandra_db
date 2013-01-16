<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Common/GetCFS.php'); ?>
<?php include_once('Common/CheckCFS.php'); ?>
<?php include_once('SearchRelated/SearchRelated/MultiAddSearchRelated/MultiAddSearchRelatedCheckParams.php'); ?>
<?php include_once('SearchRelated/SearchRelated/MultiAddSearchRelated/MultiAddSearchRelatedDealWith.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnNameSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnValueSearchRelated.php'); ?>
<?php include_once('Common/MultiSetData.php'); ?>
<?php include_once('Common/MultiAddCompileRows.php'); ?>
<?php ?>
<?php
/**********
 * # MEMO
 * 多個 keys 的 MultiAdd. 
 * (MultiAdd 是 final, 不會再做更多的 DealWith (exception: MultiAddUserFlowPostee). 並且預期所有的 data 都已經存在.)
 * 
 * #### GENERAL REQUIRE
 * 1. params['key_ids']
 * 2. 除了 the_timestamp/info/column_name_id 以外. 其他的 column_name/column_value 都需要存在. 
 * 3. 或是已經 compile 好的 params['rows'] (連 the_timestamp/info/column_name_id 都已經 compile 進去. 是 array(key => array(column_name => column_value)) 的形式.))
 * #### More
 * 最單純的 call: MultiAddSearchRelated($params, "", "", null, false, false);
 *
 * # DO
 * 1. 如果沒有 rows 的話:
 * 1.1. 檢查 params (CheckParams)
 * 1.2. serialize key/column_name/column_value. 設定 new_obj.
 * 2. 設定 add_rows.
 * 3. 拿到 CF.
 * 4. MultiSetData.
 * 5. 如果要做 is_deal_with 而且沒有 params['rows']: 做 DealWith
 */

function MultiAddSearchRelated(&$params, $col_start = "", $col_end = "", $ttl = null, $is_check_params = true, $is_deal_with = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
    
  $result = array("error" => 0);
  $function_name = "MULTI_ADD";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  /**********
   * 1.
   */

  if(!isset($params['rows'])) {
    if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

    if($is_check_params && $result_check_params = MultiAddSearchRelatedCheckParams($params, $result)) {
      $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }
        
    if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];
    
    if(isset($params['column_name_id'])) $column_name_id = $params['column_name_id']; else $column_name_id = SerializeColumnNameSearchRelated($params);
    $params['column_name_id'] = $column_name_id;
    $params['column_name_id_format'] = FormatKeyString($params['column_name_id']);
    if(isset($params['column_value_id'])) $column_value_id = $params['column_value_id']; else $column_value_id = SerializeColumnValueSearchRelated($params);
    $params['column_value_id'] = $column_value_id;
        
    $new_obj[$column_name_id] = $column_value_id;

    Debug("INFO", $DEBUG_FILENAME, "", "column_name_id: $column_name_id column_value_id: $column_value_id");
  }
        
  /**********
   * 設定 cassandra 需要的 column family
   */
    
  if(isset($params['rows'])) $add_rows =& $params['rows'];
  else $add_rows = MultiAddCompileRows($params['key_ids'], $new_obj);

  Debug("INFO", $DEBUG_FILENAME, "after MultiAddCompileRows: add_rows", $add_rows);

  $cf_search_related = GetCFS('search_related', $params);
  if(CheckCFS(array($cf_search_related))) {
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'CFS');
    return $result;
  }
    
  if(MultiSetData($cf_search_related, $add_rows, $ttl)) {
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'MULTISET');
    return $result;
  }

  if(isset($params['rows']))
    if(!isset($params['rows_is_deal_with']) || !$params['rows_is_deal_with']) $is_deal_with = false;

  $key_ids = isset($params['key_ids']) ? $params['key_ids'] : array_keys($add_rows);
  if($is_deal_with && $result_deal_with = MultiAddSearchRelatedDealWith($key_ids, $params, $result)) {
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'API1_DEAL_WITH', $result_deal_with);
    return $result;
  }

  /**********
   * return
   */
  return $result;
}
?>
