<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/DebugArray.php'); ?>
<?php include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use cassandra\NotFoundException;
use cassandra\TimedOutException;
/**********
 * RemoveData
 * @memo (對於 RemoveData 的描述)
 *     (RemoveData 做了哪些步驟)
 * 
 * @param name              (對於這個 param 的描述)
 * 
 * @return error            (對於這個 return 的描述)
 *
 * @TODO implement 這個 function
 */

function RemoveData($cf, $key, &$col_names) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $NoSQL['DEBUG_CF_COUNT']++;
  
  if($key === "" || $key === null) return 1;

  Debug("WARNING_REMOVE_DATA", __LINE__ . $DEBUG_FILENAME, "cf: " . $cf->column_family . " key: $key col_names", $col_names);

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = 2;
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    if(($result_data_core = RemoveDataCore($cf, $key, $col_names)) != 2) {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }
  $result = $result_data_core;

  return $result;
}

function RemoveDataCore(&$cf, &$key, &$col_names) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  try { 
    if(empty($col_names)) 
      $cf->remove($key, null);
    else
      $cf->remove($key, $col_names);
  } catch(TimedOutException $e2) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key col_names", $col_names);
    return 2;
  } catch(Exception $e) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key col_names", $col_names);
    return 2;
  }
  return 0;
}

?>
