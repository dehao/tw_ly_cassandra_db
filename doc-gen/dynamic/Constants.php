<?php include_once('Common/ConstantsDev.php'); ?>
<?php include_once('Common/ConstantsApi1ErrorCode.php'); ?>
<?php include_once('Common/ConstantsApi1.php'); ?>
<?php ?>
<?php
use cassandra\ConsistencyLevel;
/**********
 */

$GLOBALS["SUB_STRING_LENGTH"] = 11;
$GLOBALS["SEARCH_RELATED_CONTEXT_N_PREFIX"] = 0;
$GLOBALS["SEARCH_RELATED_CONTEXT_N_POSTFIX"] = 0;
$GLOBALS["SEARCH_RELATED_CONTEXT_LINES"] = 1;
$GLOBALS["SEARCH_RELATED_INDEX_DEFAULT_KEY"] = "";
$GLOBALS['INT_MAX'] = 2147483646;
$GLOBALS["BLOCK_N_LINES"] = 30;
$GLOBALS["COMPILE_BLOCK_N_COMPILE"] = 100000;
$GLOBALS["COMPILE_BLOCK_MEM_SIZE"] = 200000;
$GLOBALS["IMPORT_RETRY"] = 5;
$GLOBALS["IMPORT_TIME_USLEEP"] = 500000;

$NoSQL['INT_MAX'] = 2147483646;
$NoSQL["CASSANDRA_TIMES_RETRY"] = 2;
$NoSQL["CASSANDRA_POOL_SIZE"] = 10;
$NoSQL["CASSANDRA_TIMEOUT"] = 5000;
$NoSQL["CASSANDRA_SET_TIMES_RETRY"] = 2;
$NoSQL["CASSANDRA_SET_TIME_USLEEP"] = 100000;
$NoSQL["CASSANDRA_MAGIC_HASH_SUBSTR"] = -6;
 
define('LENGTH_GET_DATA', 150);

if(!isset($NoSQL['CASSANDRA_CFS']))
  $NoSQL['CASSANDRA_CFS'] = array();
if(!isset($NoSQL['CASSANDRA_CONNECTION_POOL']))
  $NoSQL['CASSANDRA_CONNECTION_POOL'] = null;

if(!isset($NoSQL['DEBUG_CF_COUNT']))
  $NoSQL['DEBUG_CF_COUNT'] = 0;

?>
<?php ?>