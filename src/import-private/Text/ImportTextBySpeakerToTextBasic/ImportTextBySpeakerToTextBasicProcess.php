<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/Search/SearchCompile.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileText.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileIndex.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCore.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessMultiAddSearchText.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessMultiAddSearchIndex.php'); ?>
<?php include_once('Text/ImportTextBySpeakerToTextBasic/ImportTextBySpeakerToTextBasicProcess/ImportTextBySpeakerToTextBasicProcessCore.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextBySpeakerToTextBasicProcess
 * @memo (對於這個 function 的描述)
 *       (這個 function 做了哪些步驟)
 *
 * @param params                         (這個 function 的 input)
 *
 * @return is_error                     是否有 error: 0: 沒有 erorr. 其他: 有 error.
 * 
 * @TODO (這個 function 的 todo)
 */

function ImportTextBySpeakerToTextBasicProcess(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;
  $NoSQL["DEBUG"] = false;

  $params['filename'] = basename($params['filename']);

  $text = $params['text'];
  $filename = $params['filename'];

  $text_ary = ImportTextToTextBasicProcessTextAry($text);

  foreach($text_ary as $each_line => $each_text) {
    if(!preg_match("/：/smu", $each_text)) continue;
    $each_text_ary = ImportTextBySpeakerToTextBasicProcessParseEachTextAry($each_text);

    $the_speaker = $each_text_ary['speaker'];
    $the_text =  $each_text_ary['text'];
    if($the_text === "") continue;

    $compile_text = SearchCompile($the_text, $each_line);
    
    $rows_compile = ImportTextToTextBasicProcessCompileText($compile_text, $the_speaker, $filename, $params, $each_line);
    ImportTextToTextBasicProcessMultiAddSearchText($rows_compile);

    $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile, $params);
    ImportTextToTextBasicProcessMultiAddSearchIndex($rows_index_compile);
  }

  return 0;
}
?>
