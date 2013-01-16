<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('SearchRelated/SearchRelated/CalcScoreSearchRelated/CalcScoreSearchRelatedCheckParams.php'); ?>
<?php include_once('SearchRelated/SearchRelated/CalcScoreSearchRelated/CalcScoreSearchRelatedPreprocess.php'); ?>
<?php include_once('SearchRelated/SearchRelated/CalcScoreSearchRelated/CalcScoreSearchRelatedDealWith.php'); ?>
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

function CalcScoreSearchRelated(&$params, &$result) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  CalcScoreSearchRelatedCheckParams($params, $result);
    
  /**********
   * 2. 
   */
  CalcScoreSearchRelatedPreprocess($params, $result);

  /**********
   * 2. 
   */
  CalcScoreSearchRelatedDealWith($params, $result);


  /**********
   * return
   */

  return;
}
?>
