<?php ?>
<?php

function JsonDecode($str, $columns = null) {
  $DEBUG_FILENAME = "src/php-common/Common/JsonDecode";

  $str_ary = json_decode($str, true);

  $result = array();
  if($columns !== null) {
    foreach($columns as $each_column_idx => $each_column)
      $result[$each_column] = $str_ary[$each_column_idx];
  }
  else
    $result = $str_ary;

  return $result;
}
?>
