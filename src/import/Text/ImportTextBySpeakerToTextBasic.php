<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('Text/ImportTextBySpeakerToTextBasic/ImportTextBySpeakerToTextBasicProcess.php'); ?>
<?php
/**********
 * ImportTextBySpeakerToTextBasic
 * @memo: (對於 ImportTextBySpeakerToTextBasic 的描述)
 *        (這個 function 做了哪些步驟)
 *
 * @param filename                                                    filename
 *
 * @return                                                            
 *
 * @TODO: 
 */
function ImportTextBySpeakerToTextBasic($argv) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $filename = $argv[1];
  $prefix = $argv[2];
  $content = file_get_contents($filename);
  $start_time = GetTimestamp();
  $str = $content;
  if($str === null || $str == "") continue;
  
  $v2_ary = array($str, $filename, $prefix);
  
  $v2_st = array('setter_id' => 0);
  
  $v2_st['text'] = $v2_ary[0];
  $v2_st['filename'] = $v2_ary[1];
  $v2_st['prefix'] = $v2_ary[2];
  
  ImportTextBySpeakerToTextBasicProcess($v2_st);
  
  $end_time = GetTimestamp();
  $diff_time = $end_time - $start_time;
  Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "", "start_time: $start_time end_time: $end_time diff_time: $diff_time");
  
  return;
}
?>
