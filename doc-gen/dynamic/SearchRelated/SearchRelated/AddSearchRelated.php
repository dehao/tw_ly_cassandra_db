<?php
//////////
/// # MEMO
/// 增加到 search_related<br />
///<br />
/// #### GENERAL REQUIRE<br />
/// 1. params['key_id']/(表示 key 的 id (請參考 dynamic::search_related))<br />
/// 2. 除非有在 dynamic::search_related 特別說明. 否則 column_name/column_value 裡的 structure 都需要設定. <br />
/// 2.1. (column_name_id_format 在 api-1 會自動設定. the_timestamp/info 是 optional)<br />
/// 3. 如果 2 沒有辦法提供的話. 可以直接提供 column_name_id/column_value_id<br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] Add</li></ul>
/// 
/// # Params
/// @param [(0)!in] &$params                                          <ul><li>type: hash</li><li>[中文(傳統)] 請參考 dynamic::search_related</li><li>see: dynamic:: SearchRelated.php</li></ul>
/// @param [!in] $params['setter_id']                                 <ul><li>type: string</li><li>[中文(傳統)] $params['setter id']</li><li>see: fixed:: SearchRelated.php</li></ul>
/// @param [!in] $params['key_id']                                    <ul><li>type: string</li><li>[中文(傳統)] key_id</li></ul>
/// @param [=in] $params['session'] = [not_isset]                     <ul><li>type: string</li><li>[中文(傳統)] $params['session'] = [not isset]</li><li>see: fixed:: SearchRelated.php</li></ul>
/// @param [=in] $params['cols'] = [not_isset]                        <ul><li>type: string</li><li>[中文(傳統)] 以 array(column_name_id => column_value_id) 表示的 cols. (column_name_id 和 column_value_id 可以用 SerializeColumnNameSearchRelated 和 SerializeColumnValueSearchRelated 取得) (適用於對於同 1 個 key add 很多個 cols.)</li></ul>
/// @param [(1)=in] $ttl = null                                       <ul><li>type: string</li><li>[中文(傳統)] time to live, 目前都是設成 null</li></ul>
/// @param [(2)=in] $is_check_params = true                           <ul><li>type: string</li><li>[中文(傳統)] (api-1 only) 是否要執行 CheckParams</li></ul>
/// @param [(3)=in] $is_deal_with = true                              <ul><li>type: string</li><li>[中文(傳統)] (api-1 only) 是否要執行 DealWith</li></ul>
/// @param [=out] error                                               <ul><li>type: string</li><li>[中文(傳統)] error code</li></ul>
/// @param [=out] column_name_id_format                               <ul><li>type: string</li><li>[中文(傳統)] column_name_id_format</li></ul>
/// @param [=out] column_name_id                                      <ul><li>type: key</li><li>[中文(傳統)] column_name_id</li></ul>
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
/// 
/// # CheckParams
/// # DealWith
//////////
function AddSearchRelated(&$params, $ttl = null, $is_check_params = true, $is_deal_with = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $result = array("error" => 0);
  $function_name = "ADD";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  $key_id = null;
  if(isset($params['cols'])) {
    if(isset($params['key_id'])) $key_id = $params['key_id']; else $key_id = SerializeKeySearchRelated($params);
    $params['key_id'] = $key_id;
  }
  else {
    if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

    //1.2
    if($is_check_params && $result_check_params = AddSearchRelatedCheckParams($params, $result)) {
      $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'API1_CHECK_PARAMS', $result_check_params);
      return $result;
    }

    if(!isset($params['info'])) $params['info'] = $NoSQL['LEFT_BRACKET'] . $NoSQL['RIGHT_BRACKET'];

    //1.4.
    if(isset($params['key_id'])) $key_id = $params['key_id']; else $key_id = SerializeKeySearchRelated($params);
    $params['key_id'] = $key_id;

    if(!isset($params['cols'])) {
      if(isset($params['column_name_id'])) $column_name_id = $params['column_name_id']; else $column_name_id = SerializeColumnNameSearchRelated($params);
      $params['column_name_id'] = $column_name_id;
      $params['column_name_id_format'] = FormatKeyString($params['column_name_id']);
      if(isset($params['column_value_id'])) $column_value_id = $params['column_value_id']; else $column_value_id = SerializeColumnValueSearchRelated($params);
      $params['column_value_id'] = $column_value_id;
    }
  }

  //2.
  $cf_search_related = GetCFS('search_related', $params);
  if(CheckCFS(array($cf_search_related))) {
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'CFS');
    return $result;
  }

  //3.
  if(isset($params['cols'])) $cols =& $params['cols'];
  else $cols[$column_name_id] = $column_value_id;
  if(SetData($cf_search_related, $key_id, $cols)) { //設定 search_related1 錯誤.
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'CF1');
    return $result;
  }

  if(isset($params['cols'])) {
    $column_name_ids = array_keys($params['cols']);

    $column_name_ids_format = array();
    foreach($column_name_ids as $each_column_name_id) {
      $each_column_name_id_format = FormatKeyString($each_column_name_id);
      $column_name_ids_format[$each_column_name_id_format] = $each_column_name_id_format;
    }
    $result['column_name_id_format'] = $column_name_ids_format;
    $result['column_name_id'] = $column_name_ids;
  }
  else {
    $result['column_name_id_format'] = FormatKeyString($params['column_name_id']);
    $result['column_name_id'] = $params['column_name_id'];
  }
    

  //4.
  if($is_deal_with && $result_deal_with = AddSearchRelatedDealWith($key_id, $params, $result)) {
    $result['error'] = ErrorCode('SEARCH_RELATED', $function_name, 'API1_DEAL_WITH', $result_deal_with);
    return $result;
  }

  /**********
   * return
   */
  return $result;
}
?>
