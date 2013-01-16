<?php include_once('Common/Constants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
use cassandra\NotFoundException;
use cassandra\TimedOutException;
/********************
 * SetData
 * @memo 
 *
 * @param cf
 * @param key               key
 * @param cols              相對應的 columns ( array( [column name] => [column val] ); )
 * 
 * @return 0: 成功 
 *     1: 失敗
 *
 * @TODO 1. 把 try/catch 讓外面接. (對 for-loop 或許有效)
 *     2. 確認要如何擋掉 phpcassa 的 exception
 */
function SetData($cf, $key, &$cols, $ttl = null) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $NoSQL['DEBUG_CF_COUNT']++;

  if($key === "" || $key === null) return 1;

  Debug("WARNING_SET_DATA", __LINE__ . $DEBUG_FILENAME, "cf: " . $cf->column_family . " key: $key cols", $cols);

  $the_times_retry = $NoSQL["CASSANDRA_SET_TIMES_RETRY"];
  $result_data_core = 2;
  for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
    if(($result_data_core = SetDataCore($cf, $key, $cols, $ttl)) != 2) {
      $the_times_retry = $i;
      break;
    }
    usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
  }
  $result = $result_data_core;

  return $result;

}

function SetDataCore(&$cf, &$key, &$cols, &$ttl) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  try { 
    $cf->insert($key, $cols, null, $ttl);
    Debug("INFO", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
  } catch(TimedOutException $e2) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
    return 2;
  } catch(Exception $e) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "key: $key cols", $cols);
    return 2;
  }
  return 0;
}

?>
