<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use phpcassa\ColumnSlice;
use cassandra\NotFoundException;
use cassandra\TimedOutException;
use cassandra\cassandra_TimedOutException;
/**********
 * GetCount
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function GetCount($cf, $key, &$cols, $is_reverse = false, $number = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = "api/Common/GetCount";

  $NoSQL['DEBUG_CF_COUNT']++;

  $result = null;
  
  $column_slice = new ColumnSlice($col_start, $col_end, $NoSQL["INT_MAX"], $is_reverse);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "key: $key number: $number col_start: $col_start");

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = "";
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    $result_data_core = GetCountCore($cf, $key, $cols, $column_slice);
    if(is_array($result_data_core) || $result_data_core !== "") {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }

  $result = ($result_data_core !== "" && $result_data_core !== null) ? $result_data_core : null;

  //if($result !== null) $result = min($number, $result);

  return $result;
}

function GetCountCore(&$cf, &$key, &$cols, &$column_slice) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  try {
    if(empty($cols))
      $result = $cf->get_count($key, $column_slice, null);
    else
      $result = $cf->get_count($key, $column_slice, $cols);
  } catch(NotFoundException $e2) {
    Debug("ERROR-NotFound_ERROR", __LINE__ . $DEBUG_FILENAME, "key", $key);
    return null;
  } catch(Exception $e) {
    //$e_str = print_r($e, true);
    //Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key e", $e_str);
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
    return "";
  }

  Debug("INFO-END", __LINE__ . $DEBUG_FILENAME, "result", $result);

  return $result;

}

?>
