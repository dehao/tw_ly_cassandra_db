<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/AutoComplete/AutoCompleteCompile.php'); ?>
<?php include_once('AutoComplete/AutoCompleteText/MultiAddAutoCompleteText.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/MultiAddAutoCompleteIndex.php'); ?>
<?php include_once('SearchRelated/Search/SearchCompile.php'); ?>
<?php include_once('Search/SearchText/MultiAddSearchText.php'); ?>
<?php include_once('Search/SearchIndex/MultiAddSearchIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/UnserializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnNameSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnValueSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeKeySearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnNameSearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnValueSearchRelatedIndex.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileText.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileIndex.php'); ?>
<?php include_once('Text/ImportTextToTextBasic/ImportTextToTextBasicProcess/ImportTextToTextBasicProcessCompileCore.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextToTextBasicProcess
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param 
 *
 * @return 
 * 
 * @TODO (這個 function 的 todo)
 */

function ImportTextToTextBasicProcess(&$params) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params['filename'] = basename($params['filename']);

  $prefix = $params['prefix'];
  $text = $params['text'];
  $filename = $params['filename'];

  $text_ary = ImportTextToTextBasicProcessTextAry($text);

  foreach($text_ary as $each_text_line => $each_text) {
    $search_compile = SearchCompile($the_text, $each_text_line);
    if(empty($search_compile)) continue;
    $rows_compile = ImportTextToTextBasicProcessCompileText($search_compile, $prefix, $filename, $params, $each_text_line);
    
    $params_search_text = array('rows' => $rows_compile);
    MultipleRetry("MultiAddSearchText", $params_search_text);
    
    $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile, $params);
    
    $params_search_index = array('rows' => $rows_index_compile);
    MultipleRetry("MultiAddSearchIndex", $params_search_index);
  }

  return 0;
}

function ImportTextToTextBasicProcessTextAry($text) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $text_ary = preg_split("/\n/smu", $text);
  return $text_ary;
}

?>
