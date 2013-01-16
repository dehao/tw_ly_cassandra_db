<?php
//////////
/// # MEMO
/// 多個 keys 的 MultiAdd. <br />
/// (MultiAdd 是 final, 不會再做更多的 DealWith (exception: MultiAddUserFlowPostee). 並且預期所有的 data 都已經存在.)<br />
/// <br />
/// #### GENERAL REQUIRE<br />
/// 1. params['key_ids']<br />
/// 2. 除了 the_timestamp/info/column_name_id 以外. 其他的 column_name/column_value 都需要存在. <br />
/// 3. 或是已經 compile 好的 params['rows'] (連 the_timestamp/info/column_name_id 都已經 compile 進去. 是 array(key => array(column_name => column_value)) 的形式.))<br />
/// #### More<br />
/// 最單純的 call: MultiAddSearchRelatedIndex($params, "", "", null, false, false);<br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] MultiAdd</li></ul>
/// 
/// # Params
/// @param [(0)!in] &$params                                          <ul><li>type: hash</li><li>[中文(傳統)] 整理好的要做 update 的 rows. 以 array(key => array(column_name => column_value)) 表示. 請參考 search_related_index 裡的 key/column_name/column_value</li><li>see: dynamic:: SearchRelatedIndex.php</li></ul>
/// @param [(1)=in] $ttl = null                                       <ul><li>type: string</li><li>[中文(傳統)] time to live, 目前都是設成 null</li></ul>
/// @param [(2)=in] $col_start = ""                                   <ul><li>type: string</li><li>[中文(傳統)] 開始的 column name</li></ul>
/// @param [(3)=in] $col_end = ""                                     <ul><li>type: string</li><li>[中文(傳統)] 停止的 column name</li></ul>
/// @param [(4)=in] $is_check_params = true                           <ul><li>type: string</li><li>[中文(傳統)] 是否要執行 CheckParams</li></ul>
/// @param [=out] error                                               <ul><li>type: string</li><li>[中文(傳統)] error code</li></ul>
/// 
/// # DO
/// 1. 如果沒有 rows 的話:
/// 1.1. 檢查 params (CheckParams)
/// 1.2. serialize key/column_name/column_value. 設定 new_obj.
/// 2. 設定 add_rows.
/// 3. 拿到 CF.
/// 4. MultiSetData.
/// 5. 如果要做 is_deal_with 而且沒有 params['rows']: 做 DealWith
/// 
/// # CheckParams
/// # DealWith
//////////
function MultiAddSearchRelatedIndex(&$params, $col_start = "", $col_end = "", $ttl = null, $is_check_params = true, $is_deal_with = true) {
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

    if($is_check_params && $result_check_params = MultiAddSearchRelatedIndexCheckParams($params, $result)) {
      $result['error'] = ErrorCode('SEARCH_RELATED_INDEX', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }
        
    if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];
    
    if(isset($params['column_name_id'])) $column_name_id = $params['column_name_id']; else $column_name_id = SerializeColumnNameSearchRelatedIndex($params);
    $params['column_name_id'] = $column_name_id;
    $params['column_name_id_format'] = FormatKeyString($params['column_name_id']);
    if(isset($params['column_value_id'])) $column_value_id = $params['column_value_id']; else $column_value_id = SerializeColumnValueSearchRelatedIndex($params);
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

  $cf_search_related_index = GetCFS('search_related_index', $params);
  if(CheckCFS(array($cf_search_related_index))) {
    $result['error'] = ErrorCode('SEARCH_RELATED_INDEX', $function_name, 'CFS');
    return $result;
  }
    
  if(MultiSetData($cf_search_related_index, $add_rows, $ttl)) {
    $result['error'] = ErrorCode('SEARCH_RELATED_INDEX', $function_name, 'MULTISET');
    return $result;
  }

  if(isset($params['rows']))
    if(!isset($params['rows_is_deal_with']) || !$params['rows_is_deal_with']) $is_deal_with = false;

  $key_ids = isset($params['key_ids']) ? $params['key_ids'] : array_keys($add_rows);
  if($is_deal_with && $result_deal_with = MultiAddSearchRelatedIndexDealWith($key_ids, $params, $result)) {
    $result['error'] = ErrorCode('SEARCH_RELATED_INDEX', $function_name, 'API1_DEAL_WITH', $result_deal_with);
    return $result;
  }

  /**********
   * return
   */
  return $result;
}
?>
