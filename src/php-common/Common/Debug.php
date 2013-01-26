<?php include_once('Common/DebugArray.php'); ?>
<?php ?>
<?php
/**********
 * Debug
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function Debug($info, $debug_filename, $prompt, $var = null, $is_echo_debug = false, $debug_backtrace_stack = null, $is_no_syslog = false) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/php-common/Common/Debug";

  if($debug_backtrace_stack === null) $debug_backtrace_stack = $NoSQL['DEBUG_BACKTRACE_STACK'];

  $pattern_nosqlroot_dir = "/" . preg_replace("/\\//", "\\/", $NoSQL["HOME_DIR"]) . "\//";
  
  $debug_filename = preg_replace($pattern_nosqlroot_dir, "", $debug_filename); 
  $debug_filename = preg_replace("/\..*?@/u", "@", $debug_filename); 

  if(!$NoSQL['DEBUG'] && preg_match("/^INFO/u", $info) && !preg_match("/^INFO-TIME/u", $info)) {
    return;
  }

  /**********
   * 1.
   */

  $NoSQL['_debug'] .= "[" . $info . "] " . $debug_filename . ": ";
  if($info == "INFO-START") $NoSQL['_debug'] .= "start: ";
  if($info == "INFO-END") $NoSQL['_debug'] .= "end: ";

  if($prompt !== null && $prompt !== "") 
    $NoSQL['_debug'] .= $prompt . ": ";

  if($var === null) $NoSQL['_debug'] .= "[var is null]\n";
  else if(is_string($var)) $NoSQL['_debug'] .= $var . "\n";
  else if(is_numeric($var)) $NoSQL['_debug'] .= $var . " (numeric)\n";
  else $NoSQL['_debug'] .= DebugArray($var);

  /**********
   * 2. 
   */
  //if(preg_match("/^ERROR/", $info))
  if($info == "ERROR" || $info == "ERROR-MULTI_SET_DATA")
    Debug("DEBUG-BACKTRACE", $DEBUG_FILENAME, "", debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $debug_backtrace_stack), false, null, true);

  //error_log($NoSQL['_debug']);
  //$NoSQL["_debug"] = "";

  //if($is_echo_debug) EchoDebug();

  /*
    if(!$is_no_syslog) {
    $syslog_flag = preg_match("/^ERROR/", $info) ? LOG_ERR : LOG_NOTICE;
    syslog($syslog_flag, $NoSQL['_debug']);
    $NoSQL['_debug'] = "";
    }
  */

  if(!isset($NoSQL['DEBUG_COUNT'])) $NoSQL['DEBUG_COUNT'] = 0;
  else
    $NoSQL['DEBUG_COUNT']++;

  //EchoDebug();

  /*
    if($NoSQL['DEBUG_COUNT'] == 100) {
    $NoSQL['DEBUG_COUNT'] = 0;
    EchoDebug();
    }
  */

  /**********
   * return
   */

  return;
}
?>
