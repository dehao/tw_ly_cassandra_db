<?php include_once('Common/Constants.php'); ?>
<?php ?>
<?php
use phpcassa\ColumnSlice;
/**********
 * GetIndexedData
 * @memo 用 index_clause 來拿到 data
 * 
 * @param index_clause index_clause
 * @param cols 相對應的 columns ( array([column name]); )
 * @param is_reverse 是否要 reverse 的查. (如果是 reverse, 傳回來是由大到小.)
 * @param number 傳回來上限的個數.
 * @param col_start 開始的 col.
 * @param col_end 結束的 col.
 * 
 * @return 0: 成功 
 *     1: 失敗
 *
 * @TODO
 */
function GetIndexedData($cf, $index_clause, &$cols, $is_reverse = false, $number = LENGTH_GET_DATA, $col_start = "", $col_end = "") {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $NoSQL['DEBUG_CF_COUNT']++;

  $result = null;
  //$NoSQL['_debug'] .= "[INFO] api/Common/GetIndexedData: cols: " . $cols . " is_reverse: " . $is_reverse . " number: " . $number . " col_start: " . $col_start . " col_end: " . $col_end . "<br />";
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "cf", $cf);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "index_clause", $index_clause);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "cols", $cols);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "col_start: $col_start col_end: $col_end is_reverse: $is_reverse number: $number");

  $column_slice = new ColumnSlice($col_start, $col_end, $number, $is_reverse);

  try { 
    if(!empty($cols)) 
      $result = $cf->get_indexed_slices($index_clause, $column_slice, $cols);
    else
      $result = $cf->get_indexed_slices($index_clause, $column_slice, null);
  } catch(Exception $e) {
    $result = null;
  }
  return $result;
}
?>
