<?php include_once('Common/Constants.php'); ?>
<?php ?>
<?php
/**********
 * GetServers
 * @memo 取得 servers
 * 
 * @param
 * 
 * @return cassandra 的 server
 * 
 * @TODO random 選兩個 server, 取 load 小的那個.
 */
function GetServers() {
  global $NoSQL;
  $servers = $NoSQL['SERVERS'];
  return $servers;
}
?>
