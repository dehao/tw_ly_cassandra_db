<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php ?>
<?php
/**********
 * MultiAddCompileRows
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function MultiAddCompileRows(&$key_ids, &$obj) {
  global $NoSQL;
  $DEBUG_FILENAME = "src/api/Common/MultiAddCompileRows";

  $result = array();
  foreach($key_ids as $each_key) {
    $result[$each_key] =& $obj;
  }

  return $result;
}
?>
