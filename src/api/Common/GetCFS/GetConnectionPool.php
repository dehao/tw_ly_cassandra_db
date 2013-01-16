<?php include_once('Common/Constants.php'); ?>
<?php include_once('Common/GetCFS/InitCassandraPool.php'); ?>
<?php ?>
<?php
/**********
 * GetConnectionPool 
 * @memo 取得相對應的 connection pool ($NoSQL['CASSANDRA_CONNECTION_POOL'])
 *
 * @param 
 *
 * @return connection pool
 *
 * @TODO
 */
function GetConnectionPool() {
  global $NoSQL;
  if($NoSQL['CASSANDRA_CONNECTION_POOL'] === null)
    $NoSQL['CASSANDRA_CONNECTION_POOL'] = InitCassandraPool();
  return $NoSQL['CASSANDRA_CONNECTION_POOL'];
}

?>
