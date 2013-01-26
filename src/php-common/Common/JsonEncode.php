<?php ?>
<?php

function JsonEncode($params, $columns = null) {
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $cols = array();
  $n_columns = 0;
    
  if($columns === null) 
    $cols = $params;
  else {
    foreach($columns as $each_column) $cols[] = (string)$params[$each_column];
    $n_columns = count($columns);
  }

  $str = $n_columns == 1 ? $cols[0] : json_encode($cols, JSON_UNESCAPED_UNICODE);
  
  return $str;
}
?>
