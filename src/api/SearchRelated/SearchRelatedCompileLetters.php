<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/SearchRelatedPurifyString.php'); ?>
<?php ?>
<?php
/**********
 *
 */

function SearchRelatedCompileLetters($str) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $str = SearchRelatedPurifyString($str);
  $result = $str === "" ? array() : preg_split('/(?<!^)(?!$)/u', $str);

  return $result;
}

?>
