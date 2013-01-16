<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/CalcScoreAutoCompleteIndex/CalcScoreAutoCompleteIndexCheckParams.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/CalcScoreAutoCompleteIndex/CalcScoreAutoCompleteIndexPreprocess.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/CalcScoreAutoCompleteIndex/CalcScoreAutoCompleteIndexDealWith.php'); ?>
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

function CalcScoreAutoCompleteIndex(&$params, &$result) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  CalcScoreAutoCompleteIndexCheckParams($params, $result);
    
  /**********
   * 2. 
   */
  CalcScoreAutoCompleteIndexPreprocess($params, $result);

  /**********
   * 2. 
   */
  CalcScoreAutoCompleteIndexDealWith($params, $result);


  /**********
   * return
   */

  return;
}
?>
