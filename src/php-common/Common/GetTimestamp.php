<?php
/**********
 * GetTimestamp
 * @memo 拿到現在時間的 timestamp
 * 
 * @param 
 * 
 * @return 現在時間的 timestamp
 *
 * @TODO
 */
function GetTimestamp() {
  global $NoSQL;
  $DEBUG_FILENAME = __FILE__ . "::" . __FUNCTION__ . "::";

  date_default_timezone_set('UTC');
  $current_time_st = gettimeofday();
  $current_time_sec = sprintf($NoSQL['FORMAT_TIME_SEC'], $current_time_st["sec"]);
  $current_time_usec = str_pad(substr($current_time_st["usec"], 0, $NoSQL['PRECISION_TIME_USEC']), $NoSQL['PRECISION_TIME_USEC'], '000000');
  $timestamp = $current_time_sec . $current_time_usec;

  //Debug("INFO", $DEBUG_FILENAME . __LINE__ , "current_time_sec: $current_time_sec current_time_usec: $current_time_usec timestamp: $timestamp current_time_st", $current_time_st);

  return $timestamp;
}
?>
