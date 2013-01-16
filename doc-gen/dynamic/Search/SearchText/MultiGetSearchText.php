<?php
//////////
/// # MEMO
/// 多個 key_ids 拿到 data<br />
/// <br />
///
/// 
/// [MORE]                                                            <ul><li>[中文(傳統)] MultiGet</li></ul>
/// 
/// # Params
/// @param [(0)!in] &$params                                          <ul><li>type: hash</li><li>[中文(傳統)] 其他額外的 params, 如果沒有的話. 要傳 array() (而且是在 function 外存在的 variables)</li></ul>
/// @param [!in] $params['getter_id']                                 <ul><li>type: string</li><li>[中文(傳統)] 是誰拿的. (for privacy_check)</li></ul>
/// @param [=in] $params['session'] = [not_isset]                     <ul><li>type: string</li><li>[中文(傳統)] $params['session'] = [not isset]</li><li>see: fixed:: SearchText.php</li></ul>
/// @param [=in] $params['cf'] = unset                                <ul><li>type: string</li><li>[中文(傳統)] 是否其實是要從其他 cf 裡面拿資料 (search_text 不用傳).</li></ul>
/// @param [(1)!in] &$key_ids                                         <ul><li>type: array</li><li>[中文(傳統)] key_ids</li></ul>
/// @param [(2)=in] $column_names = null                              <ul><li>type: array</li><li>[中文(傳統)] null: 全部, 如果有 specify 哪些 column_names 裡的話. 就會只傳回這些 column_names</li></ul>
/// @param [(3)=in] $is_reverse = true                                <ul><li>type: string</li><li>[中文(傳統)] 是否從新到舊排序 (按 unicode 從大到小排序): true: yes false: no</li></ul>
/// @param [(4)=in] $max_length = 100                                 <ul><li>type: string</li><li>[中文(傳統)] 最大的長度 (全傳)</li></ul>
/// @param [(5)=in] $col_start = ""                                   <ul><li>type: string</li><li>[中文(傳統)] 開始的 column name</li></ul>
/// @param [(6)=in] $col_end = ""                                     <ul><li>type: string</li><li>[中文(傳統)] 停止的 column name</li></ul>
/// @param [(7)=in] $is_with_start = false                            <ul><li>type: string</li><li>[中文(傳統)] 如果有 col_start 的話. 是否要把 col_start 資訊也傳回. (default 是 false)</li></ul>
/// @param [=out] error                                               <ul><li>type: string</li><li>[中文(傳統)] error code, 都不存在會回 error</li></ul>
/// @param [=out] result                                              <ul><li>type: hash</li><li>[中文(傳統)] 以 array(key => array(column name => column value)) 傳回. 不存在的 key/column name 不會傳回.</li></ul>
/// 
/// # DO
/// 1. 設定 column_names/max_length
/// 2. 拿到 CF
/// 3. MultiGetData.
/// 
//////////
function MultiGetSearchText(&$params, &$key_ids, $column_names = null, $is_reverse = true, $max_length = LENGTH_GET_DATA, $col_start = "", $col_end = "", $is_with_start = false) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 檢查 params 是 ok 的.
   */
  $result = array("error" => 0);
  $function_name = "MULTI_GET";

  if(isset($params['session']) && !isset($NoSQL['SESSION'])) $NoSQL['SESSION'] = $params['session'];

  $orig_max_length = $max_length;

  if($max_length <= 0) {
    Debug("ERROR_LENGTH", __LINE__ . $DEBUG_FILENAME, "", "max_length: $max_length");
    $result['error'] = ErrorCode('SEARCH_TEXT', $function_name, 'API1_CHECK_PARAMS', $NoSQL['ERROR_AVAILABLE']);
    return $result;
  }

  if(!isset($params['the_timestamp'])) $params['the_timestamp'] = GetTimestamp();

  /*****
   * 多加 1 個.
   */
  if($col_start !== "" && $is_with_start === false) $max_length++;

  /**********
   * 設定 variables 
   */
  if($column_names === null) $column_names= Array();
  else $max_length = min($max_length, count($column_names));

  /**********
   * 設定 cassandra 需要的 column family
   */
  $cf_search_text = GetCFS('search_text', $params);
  if(CheckCFS(array($cf_search_text))) {
    $result['error'] = ErrorCode('SEARCH_TEXT', $function_name, 'CFS');
    return $result;
  }

  /**********
   * 設定 cassandra 需要的 variables
   */

  /**********
   * 執行 cassandra 裡的 functions.
   */
  $data = MultiGetData($cf_search_text, $key_ids, $column_names, $is_reverse, $max_length, $col_start, $col_end);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after MultiGetData: data", $data);
  if($data === null) {
    //$result['error'] = ErrorCode('SEARCH_TEXT', $function_name, 'MULTIGET');
    //return $result;
    $result['result'] = array();
    return $result;
  }
  if($col_start !== "" && $is_with_start === false) {
    foreach($data as $each_data_key => $each_data_cols) {
      GetDataRemoveFirstColumnName($each_data_cols, $col_start, $is_with_start, $orig_max_length);
    }
  }

  $result['result'] = $data;
    
  return $result;
}
?>
