<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use cassandra\NotFoundException;
use cassandra\TimedOutException;
/**********
 * MultiSetData
 * @memo (對於這個 function 的描述)
 *       (這個 function 做了哪些步驟)
 *
 * @param cf                            (這個 function 的 input)
 * @param rows                          相對應的 rows ( array ( [key] => array ( [column name] => [column val] ) ); ) 
 *
 * @return result                       (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function MultiSetData($cf, &$rows, $ttl = null) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $NoSQL['DEBUG_CF_COUNT']++;

  //Debug("INFO", $DEBUG_FILENAME, "MultiSetData: ttl", $ttl);

/*
  $to_remove = array();
  foreach($rows as $each_key => &$each_val) {
    if(empty($each_val)) $to_remove[] = $each_key;
    else if($each_key === "" || $each_key === null) $to_remove[] = $each_key;
  }
  foreach($to_remove as $each_to_remove) unset($rows[$each_to_remove]);
*/

  if(empty($rows)) return 0;

  //Debug("DEBUG-BACKTRACE", $DEBUG_FILENAME, "", debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT));

  //Debug("WARNING_MULTI_SET_DATA", __LINE__ . $DEBUG_FILENAME, "cf: " . $cf->column_family . " rows", $rows);

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = 2;
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    if(($result_data_core = MultiSetDataCore($cf, $rows, $ttl)) != 2) {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }
  $result = $result_data_core;

  return $result;

}

function MultiSetDataCore(&$cf, &$rows, &$ttl) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "MultiSetData: rows", $rows);
  try {
    $cf->batch_insert($rows, null, $ttl);
  } catch(TimedOutException $e2) {
    Debug("ERROR-MULTI_SET_DATA", $DEBUG_FILENAME, "rows", $rows);
    return 2;
  } catch(Exception $e) {
    Debug("ERROR-MULTI_SET_DATA", $DEBUG_FILENAME, "rows", $rows);
    return 2;
  }

  return 0;
}

?>
