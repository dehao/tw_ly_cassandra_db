<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php ?>
<?php
/**********
 * purify string
 * 1. tolower
 * 2. remove unsearchable letters
 */

function SearchRelatedPurifyString($str) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . "@" . __FUNCTION__;

  $orig_str = $str;
  $str = strtolower($str);
  $str = preg_replace("/\s+/u", "", $str);
  $str = preg_replace("/[ ˋ[:punct:]\p{P}\p{S}\p{Z}\p{C}]/u", "", $str);
  $str = trim($str);

  return $str;
}

?>
