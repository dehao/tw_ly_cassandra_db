<?php include_once('Common/DeformatJsonBracket.php'); ?>
<?php ?>
<?php
/**********
 * EchoDebug
 * @memo (對於 EchoDebug 的描述)
 *     (EchoDebug 做了哪些步驟)
 * 
 * @param name              (對於這個 param 的描述)
 * 
 * @return error            (對於這個 return 的描述)
 *
 * @TODO implement 這個 function
 */

function EchoDebug($is_echo = false, $is_debug_backtrace = true) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 設定 
   */

  if($is_debug_backtrace) {
    $result_debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
    Debug("ECHO_DEBUG_BACKTRACE", __LINE__ . $DEBUG_FILENAME, "result_debug_backtrace", $result_debug_backtrace);
  }

  $file_size = 0;

  if($is_echo || $NoSQL["DEBUG_LOG_FILENAME"] == "") {
    echo $NoSQL["_debug"];
    $NoSQL["_debug"] = "";
    return;
  }

  if(!isset($NoSQL["DEBUG_LOG_FILENAME_FULL"])) {
    $the_timestamp = date('YmdHis');
    $NoSQL["DEBUG_LOG_FILENAME_FULL"] = $NoSQL["DEBUG_LOG_DIR"] . "/log." . $NoSQL["DEBUG_LOG_FILENAME"] . ".txt";
    $NoSQL["DEBUG_LOG_FILENAME_FULL_BACKUP"] = $NoSQL["DEBUG_LOG_DIR"] . "/log/log." . $NoSQL["DEBUG_LOG_FILENAME"] . "." . $the_timestamp . ".txt";
  }

  if(!isset($NoSQL["DEBUG_N_ECHO_DEBUG"])) $NoSQL["DEBUG_N_ECHO_DEBUG"] = 0;
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "DEBUG_N_ECHO_DEBUG", $NoSQL["DEBUG_N_ECHO_DEBUG"]);
  if($NoSQL["DEBUG_N_ECHO_DEBUG"] == 0) {
    clearstatcache(true, $NoSQL["DEBUG_LOG_FILENAME_FULL"]);
    $file_size = filesize($NoSQL["DEBUG_LOG_FILENAME_FULL"]);
  }
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "file_size: $file_size DEBUG_MAX_LOG_FILENAME_SIZE: " . $NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"] . " DEBUG_LOG_FILENAME_FULL", isset($NoSQL["DEBUG_LOG_FILENAME_FULL"]) ? $NoSQL["DEBUG_LOG_FILENAME_FULL"] : "[unset]");

  $NoSQL["DEBUG_N_ECHO_DEBUG"] = ($NoSQL["DEBUG_N_ECHO_DEBUG"] + 1) % $NoSQL["DEBUG_N_ECHO_DEBUG_TO_CLEAR_CACHE"];
  
  if($NoSQL["DEBUG_FD"] === null || !is_file($NoSQL["DEBUG_LOG_FILENAME_FULL"]) || $file_size > $NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"]) {
    Debug("WARNING_LOG_FILE_FULL", __LINE__ . $DEBUG_FILENAME, "", "file_size: $file_size");
    EchoDebugInitDebugFD($file_size);
  }
  
  for($i = 0; $i < $NoSQL["DEBUG_RETRY"]; $i++) {
    $result = fwrite($NoSQL["DEBUG_FD"], $NoSQL['_debug']);
    if($result !== false) break;
    
    usleep($NoSQL["DEBUG_TIME_USLEEP"]);
    EchoDebugInitDebugFD($NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"] + 1);
  }

  $NoSQL['_debug'] = "";

  /**********
   * 執行這個 function 要做的事情
   */

  /**********
   * return
   */
}

function EchoDebugInitDebugFD($file_size) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  if($NoSQL["DEBUG_FD"] !== null) {
    fclose($NoSQL["DEBUG_FD"]);
    $NoSQL["DEBUG_FD"] = null;
  }

  if(!is_dir($NoSQL["DEBUG_LOG_DIR"])) mkdir($NoSQL["DEBUG_LOG_DIR"], 0755, true);
  if(!is_dir($NoSQL["DEBUG_LOG_DIR_BACKUP"])) mkdir($NoSQL["DEBUG_LOG_DIR_BACKUP"], 0755, true);

  if(isset($NoSQL["DEBUG_LOG_FILENAME_FULL"]) && $NoSQL["DEBUG_LOG_FILENAME_FULL"] != "" && $file_size > $NoSQL["DEBUG_MAX_LOG_FILENAME_SIZE"]) rename($NoSQL["DEBUG_LOG_FILENAME_FULL"], $NoSQL["DEBUG_LOG_FILENAME_FULL_BACKUP"]);

  $the_timestamp = date('YmdHis');
  $NoSQL["DEBUG_LOG_FILENAME_FULL"] = $NoSQL["DEBUG_LOG_DIR"] . "/log." . $NoSQL["DEBUG_LOG_FILENAME"] . ".txt";
  $NoSQL["DEBUG_LOG_FILENAME_FULL_BACKUP"] = $NoSQL["DEBUG_LOG_DIR"] . "/log/log." . $NoSQL["DEBUG_LOG_FILENAME"] . "." . $the_timestamp . ".txt";

  Debug("WARNING", __LINE__ . $DEBUG_FILENAME, "", "new DEBUG filename: " . $NoSQL["DEBUG_LOG_FILENAME_FULL"]. "\n");
  $NoSQL["DEBUG_FD"] = fopen($NoSQL["DEBUG_LOG_FILENAME_FULL"], "a");

  
}

?>
