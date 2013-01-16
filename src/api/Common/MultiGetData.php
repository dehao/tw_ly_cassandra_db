<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use phpcassa\ColumnSlice;
use cassandra\NotFoundException;
use cassandra\TimedOutException;
use cassandra\cassandra_TimedOutException;
/**********
 * MultiGetData
 * @memo (對於 MultiGetData 的描述)
 *       (MultiGetData 做了哪些步驟)
 * 
 * @param name                          (對於這個 param 的描述)
 * 
 * @return error                        (對於這個 return 的描述)
 *
 * @TODO implement 這個 function
 */

function MultiGetData($cf, &$keys, &$cols, $is_reverse = false, $number = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = "src/api/Common/MultiGetData";

  $NoSQL['DEBUG_CF_COUNT']++;

  $result = null;
  Debug("INFO", $DEBUG_FILENAME, "is_reverse: $is_reverse number: $number col_start: $col_start col_end: $col_end keys", $keys);
  Debug("INFO", $DEBUG_FILENAME, "cols", $cols);

  $to_remove_ary = array();
  foreach($keys as $each_key_id_key => &$each_key_id_val) {
    if($each_key_id_val === "" || $each_key_id_val === null) $to_remove_ary[] = $each_key_id_key;
  }
  foreach($to_remove_ary as $each_to_remove) unset($keys[$each_to_remove]);

  if(empty($keys)) return array();

  $column_slice = new ColumnSlice($col_start, $col_end, $number, $is_reverse);

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = "";
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    $result_data_core = MultiGetDataCore($cf, $keys, $cols, $column_slice);
    if(is_array($result_data_core) || $result_data_core !== "") {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }

  $result = ($result_data_core !== "" && $result_data_core !== null) ? $result_data_core : null;

  return $result;
}

function MultiGetDataCore(&$cf, &$keys, &$cols, &$column_slice) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  try { 
    if(!empty($cols))
      $result = $cf->multiget($keys, $column_slice, $cols);
    else
      $result = $cf->multiget($keys, $column_slice, null);
  } catch(NotFoundException $e2) {
    Debug("ERROR-NotFound_ERROR", __LINE__ . $DEBUG_FILENAME, "keys", $keys);
    return null;
  } catch(Exception $e) {
    //$e_str = print_r($e, true);
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "keys", $keys);
    //Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "e", $e_str);
    return "";
  }

  Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "result", $result);
  return $result;
}

?>
