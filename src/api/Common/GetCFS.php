<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetCFS/GetConnectionPool.php'); ?>
<?php ?>
<?php
use phpcassa\ColumnFamily;
use cassandra\NotFoundException;
use cassandra\TimedOutException;
use cassandra\cassandra_TimedOutException;
use cassandra\ConsistencyLevel;
/**********
 * GetCFS 
 * @memo 取得相對應的 column family ($NoSQL['CASSANDRA_CFS'])
 *
 * @param cf_name column family 的名字
 *
 * @return 相對應的 column family
 *
 * @TODO
 */
function GetCFS($cf_name, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $debug_start_time = GetTimestamp();

  Debug("INFO", $DEBUG_FILENAME, "params", $params);
  if(!is_array($params)) {
    Debug("ERROR", $DEBUG_FILENAME, "params", $params);
  }
  else {
    if(isset($params['cf']) && $params['cf'] !== null && $params['cf'] !== "") {
      Debug("INFO", $DEBUG_FILENAME, "with params['cf']. cf_name: $cf_name change to params['cf']", $params['cf']);
      $cf_name = $params['cf'];
      unset($params['cf']);
    }
  }

  Debug("INFO", $DEBUG_FILENAME, "cf_name", $cf_name);

  $server_ary = GetServers();
  $count_server_ary = count($server_ary);

  if(!isset($NoSQL['CASSANDRA_CFS'][$cf_name]) || $NoSQL['CASSANDRA_CFS'][$cf_name] === null) {
    $is_success = false;
    for($j = 0; $j < $count_server_ary; $j++) {
      for($i = 0; $i < $NoSQL["CASSANDRA_SET_TIMES_RETRY"]; $i++) {
        Debug("INFO", __LINE__ . $DEBUG_FILENAME, "i: $i CASSANDRA_POOL_IDX_SERVER_FAIL", isset($NoSQL["CASSANDRA_POOL_IDX_SERVER_FAIL"]) ? $NoSQL["CASSANDRA_POOL_IDX_SERVER_FAIL"] : "[unset]");
        $pool = GetConnectionPool(); 
        if($pool !== null) {
          GetCFSCore($cf_name, $pool);
          
          if(isset($NoSQL['CASSANDRA_CFS'][$cf_name]) && $NoSQL['CASSANDRA_CFS'][$cf_name] !== null) {
            $is_success = true;
            break;
          }
        }
        if(isset($NoSQL['CASSANDRA_CFS'][$cf_name])) unset($NoSQL['CASSANDRA_CFS'][$cf_name]);
        usleep($NoSQL["CASSANDRA_SET_TIME_USLEEP"]);
        $NoSQL['CASSANDRA_POOL_IDX_SERVER_FAIL'] = false;
        $NoSQL['CASSANDRA_CONNECTION_POOL'] = null;
      }
      if($is_success) break;

      $NoSQL['CASSANDRA_POOL_IDX_SERVER_FAIL'] = true;
      $NoSQL['CASSANDRA_CONNECTION_POOL'] = null;
    }
  }
  
  $debug_end_time = GetTimestamp();
  $debug_diff = $debug_end_time - $debug_start_time;
  Debug("INFO-TIME", $DEBUG_FILENAME, "cf_name: $cf_name start_time: $debug_start_time end_time: $debug_end_time diff: $debug_diff DEBUG_CF_COUNT", $NoSQL["DEBUG_CF_COUNT"]);

  if(!isset($NoSQL['CASSANDRA_CFS'][$cf_name])) $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  return $NoSQL['CASSANDRA_CFS'][$cf_name];
}

function GetCFSCore(&$cf_name, &$pool) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "READ_CONSISTENCY_LEVEL: " . $NoSQL["READ_CONSISTENCY_LEVEL"]);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "WRITE_CONSISTENCY_LEVEL: " . $NoSQL["WRITE_CONSISTENCY_LEVEL"]);
  try {
    $NoSQL['CASSANDRA_CFS'][$cf_name] = new ColumnFamily($pool, $cf_name, true, true, $NoSQL['READ_CONSISTENCY_LEVEL'], $NoSQL['WRITE_CONSISTENCY_LEVEL']);
  } catch (cassandra_TimedOutException $e1) {
    Debug("ERROR-cassandra_TimedOutException_ERROR", __LINE__ . $DEBUG_FILENAME, "e1", $e1);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  } catch(TimedOutException $e2) {
    Debug("ERROR-TimedOut_ERROR", __LINE__ . $DEBUG_FILENAME, "e2", $e2);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  } catch(NotFoundException $e2) {
    Debug("ERROR-NotFound_ERROR", __LINE__ . $DEBUG_FILENAME, "e2", $e2);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  } catch(TTransportException $e2) {
    Debug("ERROR-Transport_ERROR", __LINE__ . $DEBUG_FILENAME, "e2", $e2);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  } catch(TException $e2) {
    Debug("ERROR-Transport_ERROR", __LINE__ . $DEBUG_FILENAME, "e2", $e2);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  } catch(Exception $e) {
    Debug("ERROR-NEW_COLUMN_FAMILY_ERROR", __LINE__ . $DEBUG_FILENAME, "cf_name", $cf_name);
    Debug("ERROR-NEW_COLUMN_FAMILY_ERROR", __LINE__ . $DEBUG_FILENAME, "exception: e", $e);
    //var_dump($e);
    $NoSQL['CASSANDRA_CFS'][$cf_name] = null;
  }
}

?>
