<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/Search/SearchCompile.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileText.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileIndex.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCore.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessMultiAddSearchText.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessMultiAddSearchIndex.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextToTextBasicProcess
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param params             (這個 function 的 input)
 *
 * @return is_error           是否有 error: 0: 沒有 erorr. 其他: 有 error.
 * 
 * @TODO (這個 function 的 todo)
 */

function ImportTextToTextBasicProcess(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;
  $NoSQL["DEBUG"] = false;

  $params['filename'] = basename($params['filename']);

  $prefix = $params['prefix'];
  $text = $params['text'];
  $filename = $params['filename'];

  $text_ary = ImportTextToTextBasicProcessTextAry($text);

  foreach($text_ary as $each_line => $each_text) {
    $start_time = GetTimestamp();
    $compile_text = SearchCompile($each_text, $each_line);
    $end_time = GetTimestamp();
    Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "SearchCompile: diff_time", $end_time - $start_time);

    /*****
     * SearchText
     */
    $start_time = GetTimestamp();
    $rows_compile = ImportTextToTextBasicProcessCompileText($compile_text, $prefix, $filename, $params, $each_line);
    $end_time = GetTimestamp();
    Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "ImportTextToTextBasicProcessCompileText: diff_time", $end_time - $start_time);

    $start_time = GetTimestamp();
    ImportTextToTextBasicProcessMultiAddSearchText($rows_compile);
    $end_time = GetTimestamp();
    Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "MultiAddSearchText: diff_time", $end_time - $start_time);

    /*****
     * SearchIndex
     */
    $start_time = GetTimestamp();
    $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile, $params);
    $end_time = GetTimestamp();
    Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "ImportTextToTextBasicProcessCompileIndex: diff_time", $end_time - $start_time);

    $start_time = GetTimestamp();
    ImportTextToTextBasicProcessMultiAddSearchIndex($rows_index_compile);
    $end_time = GetTimestamp();
    Debug("INFO-TIME", __LINE__ . $DEBUG_FILENAME, "MultiAddSearchIndex: diff_time", $end_time - $start_time);

    EchoDebug(true, false);
  }

  return 0;
}

function ImportTextToTextBasicProcessTextAry($text) {
  $text_ary = preg_split("/\n/smu", $text); 
  return $text_ary;
}

?>
