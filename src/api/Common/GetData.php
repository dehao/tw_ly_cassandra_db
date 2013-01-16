<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use phpcassa\ColumnSlice;
use cassandra\NotFoundException;
use cassandra\TimedOutException;
/**********
 * GetData
 * @memo
 * 
 * @param cf              column family
 * @param key               key
 * @param cols              相對應的 columns ( array([column name]); )
 * @param is_reverse          是否要 reverse 的查. (如果是 reverse, 傳回來是由大到小.)
 * @param number            傳回來上限的個數.
 * @param col_start           開始的 col.
 * @param col_end             結束的 col.
 *
 * @return 0: 成功 
 *     1: 失敗
 * 
 * @TODO
 */
function GetData($cf, $key, &$cols, $is_reverse = false, $number = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $NoSQL['DEBUG_CF_COUNT']++;

  $result = null;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "is_reverse: $is_reverse number: $number col_start: $col_start col_end: $col_end key: $key cols", $cols);
  //EchoDebug();

  if($key === "" || $key === null) return null;

  $column_slice = new ColumnSlice($col_start, $col_end, $number, $is_reverse);

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = "";
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "to GetDataCore: i: $i key: $key");
    //EchoDebug();
    $result_data_core = GetDataCore($cf, $key, $cols, $column_slice);
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "after GetDataCore: result_data_core", $result_data_core);
    //EchoDebug();
    if(is_array($result_data_core) || $result_data_core !== "") {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }

  $result = ($result_data_core !== "" && $result_data_core !== null) ? $result_data_core : null;

  if($result === null) Debug("EXCEPTION-GET_DATA", __LINE__ . $DEBUG_FILENAME, "is_reverse: $is_reverse number: $number col_start: $col_start col_end: $col_end key: $key cols", $cols);
  
  return $result;
}

function GetDataCore(&$cf, &$key, &$cols, &$column_slice) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  try { 
    if(!empty($cols))
      $result = $cf->get($key, $column_slice, $cols);
    else
      $result = $cf->get($key, $column_slice, null);

    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "key: $key result", $result);
  } catch(NotFoundException $e2) {
    Debug("ERROR-NotFound_ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
    return null;
  } catch(Exception $e) {
    //$e_str = print_r($e, true);
    //Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key e", $e_str);
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
    //EchoDebug();
    return "";
  }

  return $result;
}
?>
