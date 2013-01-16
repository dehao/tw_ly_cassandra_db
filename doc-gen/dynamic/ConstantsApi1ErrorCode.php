<?php include_once('Common/ConstantsApi1CfErrorCode.php'); ?>
<?php 

$NoSQL['ERROR_API1'] =                                  2500000000;

$NoSQL["ERROR_API1_CF_OFFSET"] =                               300;

$NoSQL['ERROR_KEY_ID'] =                                    140000;

$NoSQL['ERROR_CFS'] =                                       110000;
$NoSQL['ERROR_GET'] =                                       120000;
$NoSQL['ERROR_GET_INDEXED_DATA'] =                          130000;
$NoSQL['ERROR_MULTIGET'] =                                  140000;
$NoSQL['ERROR_GET_COUNT'] =                                 150000;
$NoSQL['ERROR_MULTIGET_COUNT'] =                            160000;
$NoSQL['ERROR_CF1'] =                                       170000;
$NoSQL['ERROR_CF2'] =                                       180000;
$NoSQL['ERROR_REMOVE'] =                                    190000;
$NoSQL['ERROR_MULTISET'] =                                  200000;
$NoSQL['ERROR_SET'] =                                       210000;

$NoSQL["ERROR_API1_SUB_FUNCTION_OFFSET"] =                  300000;
$NoSQL['ERROR_API1_CHECK_PARAMS'] =                         300000;
$NoSQL['ERROR_API1_PREPROCESS'] =                           500000;
$NoSQL['ERROR_API1_DEAL_WITH'] =                            700000;
$NoSQL['ERROR_API1_NO_USE'] =                               990000;

$NoSQL['ERROR_API1_ADD'] =                                 1000000;
$NoSQL['ERROR_API1_MULTI_ADD'] =                           3000000;
$NoSQL['ERROR_API1_GET'] =                                 5000000;
$NoSQL['ERROR_API1_MULTI_GET'] =                           6000000;
$NoSQL['ERROR_API1_GET_COUNT'] =                           8000000;
$NoSQL['ERROR_API1_MULTI_GET_COUNT'] =                     9000000;
$NoSQL['ERROR_API1_REMOVE'] =                             12000000;
$NoSQL['ERROR_API1_SERIALIZE_KEY'] =                      15000000;
$NoSQL['ERROR_API1_UNSERIALIZE_KEY'] =                    16000000;
$NoSQL['ERROR_API1_SERIALIZE_COLUMN_NAME'] =              17000000;
$NoSQL['ERROR_API1_UNSERIALIZE_COLUMN_NAME'] =            18000000;
$NoSQL['ERROR_API1_SERIALIZE_COLUMN_VALUE'] =             19000000;
$NoSQL['ERROR_API1_UNSERIALIZE_COLUMN_VALUE'] =           20000000;

function ErrorCode($cf_upper, $error_function, $error_sub_function, $error_code = 0) {
  //如果第一次設定 error (不帶 cf_name 的資訊.)
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  Debug("INFO-START", $DEBUG_FILENAME . __LINE__, "", "cf_upper: $cf_upper error_function: $error_function error_sub_function: $error_sub_function error_code: $error_code");

  if($error_code >= $NoSQL['ERROR_API1']) {
    Debug("INFO-END", $DEBUG_FILENAME . __LINE__, "", "cf_upper: $cf_upper error_function: $error_function error_sub_function: $error_sub_function error_code: $error_code");
    return $error_code; //已經處理過了.
  }

  if($error_code < $NoSQL["ERROR_API1_CF_OFFSET"]) //完全沒有處理過.
    $error_code *= 10000;
  
  $cf_error_code = $NoSQL['ERROR_API1_CF_' . $cf_upper];
  $error_function_code = $NoSQL["ERROR_API1_" . $error_function];
  $error_sub_function_code = $NoSQL["ERROR_" . $error_sub_function];

  $result_error_code = $NoSQL['ERROR_API1'] + $error_function_code + $error_sub_function_code + $error_code + $cf_error_code;
  
  if($error_sub_function_code < $NoSQL["ERROR_API1_SUB_FUNCTION_OFFSET"])
    Debug("WARNING-" . $error_sub_function, $DEBUG_FILENAME . __LINE__, "result_error_code", $result_error_code);

  Debug("INFO-END", $DEBUG_FILENAME . __LINE__, "", "cf_upper: $cf_upper error_function: $error_function error_sub_function: $error_sub_function error_code: $error_code result_error_code: $result_error_code");
  
  return $result_error_code;
}

?>
