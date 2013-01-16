<?php include_once('Common/PhpCommonConstants2.php'); ?>
<?php include_once('Common/PhpCommonConstantsGetTimestamp.php'); ?>
<?php include_once('Common/GetTimestamp.php'); ?>
<?php include_once('Common/Debug.php'); ?>
<?php include_once('Common/DebugAssert.php'); ?>
<?php require_once('phpcassa/lib/autoload.php'); ?>
<?php 
use phpcassa\ColumnFamily;
use phpcassa\ColumnSlice;
use phpcassa\Connection\ConnectionPool;
?>
<?php 
/**********
 */

date_default_timezone_set('Asia/Taipei');
if(!isset($NoSQL['is_init'])) {
  $NoSQL['is_init'] = true;
  $NoSQL['_debug'] = date(DATE_RFC2822) . ": PhpCommonConstants: DEBUG:<br />";

}

mb_internal_encoding("UTF-8");
assert_options( ASSERT_CALLBACK, 'DebugAssert');
//set_error_handler ( 'DebugError' );

//$NoSQL['DEBUG'] = true;
if(!isset($NoSQL["DEBUG_LOG_FILENAME"])) $NoSQL["DEBUG_LOG_FILENAME"] = "Api1Default";
$NoSQL["DEBUG_LOG_DIR_BACKUP"] = $NoSQL["DEBUG_LOG_DIR"] . "/log";
$NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"] = 50000000;
//$NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"] = 50000;
$NoSQL["DEBUG_N_ECHO_DEBUG_TO_CLEAR_CACHE"] = 5;

$NoSQL["DEBUG_FD"] = null;
$NoSQL["DEBUG_RETRY"] = 10;
$NoSQL["DEBUG_TIME_USLEEP"] = 10000;
$NoSQL['DEBUG_BACKTRACE_STACK'] = 6;
$NoSQL['NOT_IMPLEMENTED'] = 10000;

$NoSQL["ERROR_LAYER_OFFSET"] = 100000000;
$NoSQL["ERROR_FUNCTION_OFFSET"] = 1000000;
$NoSQL["ERROR_CODE_OFFSET"] = 10000;

$NoSQL['PHP_COMMON_DIR'] = $NoSQL['HOME_DIR'] . "/" . "src/php-common";
$NoSQL['ADMIN_DIR'] = $NoSQL['HOME_DIR'] . "/" . "admin/ly";
$NoSQL['TEMPLATE_DIR'] = $NoSQL['HOME_DIR'] . "/" . "template";
$NoSQL['DEV_DIR'] = $NoSQL['HOME_DIR'] . "/" . "dev";

$NoSQL['SRC_DIR'] = $NoSQL['HOME_DIR'] . "/" . "src";
$NoSQL['IMPORT_DIR'] = $NoSQL['SRC_DIR'] . "/" . "import";
$NoSQL['IMPORT_PRIVATE_DIR'] = $NoSQL['SRC_DIR'] . "/" . "import-private";
$NoSQL['INTERMEDIATE_API2_CORE_DIR'] = "src/api2-core";
$NoSQL['API2_CORE_DIR'] = $NoSQL['HOME_DIR'] . "/" . $NoSQL['INTERMEDIATE_API2_CORE_DIR'];
$NoSQL['API2_DIR'] = $NoSQL['SRC_DIR'] . "/" . "api2";
$NoSQL['API_DIR'] = $NoSQL['SRC_DIR'] . "/" . "api";
$NoSQL['API_CORE_DIR'] = $NoSQL['SRC_DIR'] . "/" . "api-core";

$NoSQL['IMPORT_DIR'] = $NoSQL['SRC_DIR'] . "/" . "import";
$NoSQL['IMPORT_PRIVATE_DIR'] = $NoSQL['SRC_DIR'] . "/" . "import-private";

$NoSQL["CASSANDRA_IMPORT_RETRY"] = 10;
$NoSQL["CASSANDRA_IMPORT_TIME_USLEEP"] = 500000;

/*
  $NoSQL['LEFT_BRACKET'] = "\x1";
  $NoSQL['RIGHT_BRACKET'] = "\x2";
  $NoSQL['DOT'] = "\x3";
  $NoSQL['COMMA'] = ",";

  $NoSQL['PATTERN_LEFT_BRACKET'] = "\x1";
  $NoSQL['PATTERN_RIGHT_BRACKET'] = "\x2";
  $NoSQL['PATTERN_DOT'] = "\x3";
  $NoSQL['PATTERN_COMMA'] = ",";
*/

$NoSQL['LEFT_BRACKET'] = "[";
$NoSQL['RIGHT_BRACKET'] = "]";
$NoSQL['DOT'] = '.';
$NoSQL['COMMA'] = ",";

$NoSQL['PATTERN_LEFT_BRACKET'] = "\[";
$NoSQL['PATTERN_RIGHT_BRACKET'] = "\]";
$NoSQL['PATTERN_DOT'] = "\.";
$NoSQL['PATTERN_COMMA'] = ",";

$NoSQL["DEFAULT_JSON_ARRAY"] = $NoSQL["LEFT_BRACKET"] . $NoSQL["RIGHT_BRACKET"];
?>
<?php ?>
<?php include_once('DeformatJsonBracket.php'); ?>
<?php include_once('DeformatJsonString.php'); ?>
<?php include_once('EchoDebug.php'); ?>
<?php include_once('FormatJsonString.php'); ?>
<?php include_once('FormatKeyString.php'); ?>
<?php include_once('JsonDecode.php'); ?>
<?php include_once('JsonEncode.php'); ?>
<?php include_once('WriteFile.php'); ?>
<?php include_once('br2nl.php'); ?>
