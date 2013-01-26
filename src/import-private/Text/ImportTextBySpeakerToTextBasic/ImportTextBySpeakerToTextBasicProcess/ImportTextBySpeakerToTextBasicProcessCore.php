<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedPurifyString.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function ImportTextBySpeakerToTextBasicProcessParseEachTextAry($text) {
  $text_ary = preg_split("/：/smu", $text, 2);

  if(count($text_ary) == 1) $text_ary[1] = '';

  $result = array();
  $result['speaker'] = SearchRelatedPurifyString($text_ary[0]);
  $result['text'] = SearchRelatedPurifyString($text_ary[1]);

  return $result;
}
?>
