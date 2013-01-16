<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('AutoComplete/AutoComplete/CalcScoreAutoComplete/CalcScoreAutoCompleteCheckParams.php'); ?>
<?php include_once('AutoComplete/AutoComplete/CalcScoreAutoComplete/CalcScoreAutoCompletePreprocess.php'); ?>
<?php include_once('AutoComplete/AutoComplete/CalcScoreAutoComplete/CalcScoreAutoCompleteDealWith.php'); ?>
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

function CalcScoreAutoComplete(&$params, &$result) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;
  /**********
   * 1.
   */
  CalcScoreAutoCompleteCheckParams($params, $result);
    
  /**********
   * 2. 
   */
  CalcScoreAutoCompletePreprocess($params, $result);

  /**********
   * 2. 
   */
  CalcScoreAutoCompleteDealWith($params, $result);


  /**********
   * return
   */

  return;
}
?>
