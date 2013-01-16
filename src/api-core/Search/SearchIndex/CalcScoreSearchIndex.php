<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Search/SearchIndex/CalcScoreSearchIndex/CalcScoreSearchIndexCheckParams.php'); ?>
<?php include_once('Search/SearchIndex/CalcScoreSearchIndex/CalcScoreSearchIndexPreprocess.php'); ?>
<?php include_once('Search/SearchIndex/CalcScoreSearchIndex/CalcScoreSearchIndexDealWith.php'); ?>
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

function CalcScoreSearchIndex(&$params, &$result) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  CalcScoreSearchIndexCheckParams($params, $result);
    
  /**********
   * 2. 
   */
  CalcScoreSearchIndexPreprocess($params, $result);

  /**********
   * 2. 
   */
  CalcScoreSearchIndexDealWith($params, $result);


  /**********
   * return
   */

  return;
}
?>
