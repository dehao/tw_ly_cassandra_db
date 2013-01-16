<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Search/SearchText/CalcScoreSearchText/CalcScoreSearchTextCheckParams.php'); ?>
<?php include_once('Search/SearchText/CalcScoreSearchText/CalcScoreSearchTextPreprocess.php'); ?>
<?php include_once('Search/SearchText/CalcScoreSearchText/CalcScoreSearchTextDealWith.php'); ?>
<?php ?>
<?php
/**********
 * template.Dynamic.common.CalcScore
 * @memo (對於這個 function 的描述)
 *       (這個 function 做了哪些步驟)
 *
 * @param input                         (這個 function 的 input)
 *
 * @return result                       (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function CalcScoreSearchText(&$params, &$result) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  CalcScoreSearchTextCheckParams($params, $result);
    
  /**********
   * 2. 
   */
  CalcScoreSearchTextPreprocess($params, $result);

  /**********
   * 2. 
   */
  CalcScoreSearchTextDealWith($params, $result);


  /**********
   * return
   */

  return;
}
?>
