<?php
/**********
 * CheckCFS
 * @memo 檢查是否所有的 column family 都存在.
 * 
 * @param $cfs              關於 column family 的 array
 *
 * @return error_code           0: 所有的 cf 都 ok.
 *                    1: 有的 cf 不 ok.
 *
 * @TODO 
 */
function CheckCFS($cfs) {
  global $NoSQL;
  $n_cfs = count($cfs);
  for($i = 0; $i < $n_cfs; $i++) {
    if($cfs[$i] === null)
      return 1;
  }
  return 0;
}
