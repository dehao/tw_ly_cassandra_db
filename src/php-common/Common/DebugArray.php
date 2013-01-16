<?php
/**********
 * DebugArray
 * @memo (對於 DebugArray 的描述)
 *     
 * 
 * @param &ary              要 show 的 ary (有可能只是 str 或是 obj)
 *                    pass by reference 來省空間
 * 
 * @return str              傳回 debug 結果的 str. 用 <ul><li></li></ul> 表示
 *
 * @TODO 確定 pass by val/pass by ref (DebugArray / DebugArrayRef) 和 foreach 之間的關係.
 *     1. DebugArray define pass by val/ref, 對 DebugArray pass by val/ref, 
 *     2. DebugArrayRef define pass by val/ref, 對 DebugArrayRef pass by val/ref, 
 */

function DebugArray(&$ary, $layer = 0) {
  global $NoSQL;
  $DEBUG_FILENAME = "php-common/Common/DebugArray";

  //if(!$NoSQL['DEBUG']) return "";
/**********
 * 設定 variables 
 */
  $str = "";
  if($layer) $str .= ($layer) . str_repeat("  ", $layer);
  $str .= "[INFO] $DEBUG_FILENAME: ";

  if($ary === null) {
    $str .= "<ul><li>ary is null</li></ul>\n";
    return $str;
  }

  if(count($ary) == 0) {
    $str .= "<ul><li>ary is empty</li></ul>\n";
    return $str;
  }

  /**********
   * 執行這個 function 要做的事情
   */
  $str .= str_repeat("  ", $layer) . "<ul>" . "\n";
  if(is_array($ary) || is_object($ary)) {
    foreach($ary as $key => $cols) {
      $str .= ($layer + 1) . str_repeat("  ", $layer + 1) . "<li>" . $key . " => ";
      if(is_array($cols)) {
        $str .= DebugArray($cols, $layer + 1);
        $str .= " cols is an array " . "\n";
      }
      else if(is_object($cols)) {
        $str .= DebugArray($cols, $layer + 1);
        $str .= " cols is an obj " . "\n";
      }
      else if(is_string($cols)) {
        $str .= $cols . " cols is a string ";
      }
      else if(is_numeric($cols)) {
        $str .= $cols . " cols is numeric ";
      }
      else if($cols === null) {
        $str .= " cols is null ";
      }
      else if(is_bool($cols) && $cols) {
        $str .= " cols is true ";
      }
      else if(is_bool($cols) && !$cols) {
        $str .= " cols is false ";
      }
      else if(is_bool($cols)) {
        $str .= " cols is bool";
      }
      else if(is_callable($cols)) {
        $str .= " cols is callable";
      }
      else if(is_double($cols)) {
        $str .= " cols is double";
      }
      else if(is_resource($cols)) {
        $str .= " cols is resource";
      }
      else {
        $str .= " cols is other";
      }
      $str .= ($layer + 1) . str_repeat("  ", $layer + 1) . "</li>" . "\n";
    }
    if(is_array($ary))
      $str .= str_repeat("  ", $layer) . "ary is an array";
    else
      $str .= str_repeat("  ", $layer) . "ary is an obj";
  }
  else if(is_string($ary)) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= $ary . " ary is a string";
  }
  else if(is_numeric($ary)) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= $ary . " ary is numeric";
  }
  else if($ary === null) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is null";
  }
  else if(is_bool($ary) && !$ary) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is false";
  }
  else if(is_bool($ary) && $ary) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is true";
  }
  else if(is_callable($ary)) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is callable";
  }
  else if(is_double($ary)) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is double";
  }
  else if(is_resource($ary)) {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is resource";
  }
  else {
    if($layer) $str .= ($layer) . str_repeat("  ", $layer);
    $str .= " ary is other";
  }
  if($layer) $str .= ($layer) . str_repeat("  ", $layer);
  $str .= "</ul>" . "\n";

  /**********
   * return
   */
  if($layer == 0)
    $str .= "\n";

  return $str;
}

?>
