<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetCFS/GetServers.php'); ?>
<?php ?>
<?php
use phpcassa\Connection\ConnectionPool;

/**********
 * InitCassandraPool
 * @memo initialize cassandra 的 connectio pool
 * 
 * @param
 * 
 * @return cassandra 的 connection pool
 * 
 * @TODO
 */
function InitCassandraPool() {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $server = GetServers();

  $pool = InitCassandraPoolCore($server);

  return $pool;
}

function InitCassandraPoolCore(&$server) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $keyspace_name = $NoSQL['KEYSPACE_NAME'];

  try {
    $pool = new ConnectionPool($keyspace_name, $server, $NoSQL["CASSANDRA_POOL_SIZE"], $NoSQL["CASSANDRA_TIMES_RETRY"], $NoSQL["CASSANDRA_TIMEOUT"], $NoSQL["CASSANDRA_TIMEOUT"]); 
  } catch(TException $e) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "keyspace_name: $keyspace_name server", $server);
    return null;
  } catch(Exception $e) {
    Debug("ERROR", __LINE__ . $DEBUG_FILENAME, "keyspace_name: $keyspace_name server", $server);
    return null;
  }
  return $pool;
}

?>
