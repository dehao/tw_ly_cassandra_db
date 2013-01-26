<?php set_include_path(get_include_path() . PATH_SEPARATOR . 'src/php-common'); ?>
<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . 
                 $NoSQL['PHP_COMMON_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_CORE_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_DIR']
                 ); 
?>
<?php include_once('Search/SearchIndex/SerializeKeySearchIndex.php'); ?>
<?php include_once('Search/SearchIndex/GetSearchIndex.php'); ?>
<?php include_once('Search/SearchIndex/GetCountSearchIndex.php'); ?>
<?php include_once('Search/SearchText/MultiGetCountSearchText.php'); ?>
<?php include_once('Search/SearchText/SerializeKeySearchText.php'); ?>
<?php

function GetSearchIndexKeys($data_result, $prefix) {
  $result = array();
  foreach($data_result as $each_data_result_column_name => $each_data_result_column_value) {
    $params_search_text = array('prefix' => $prefix,
                                'sub_string' => $each_data_result_column_name);
    $key_search_text = SerializeKeySearchText($params_search_text);
    $result[] = $key_search_text;
  }

  return $result;
}

function GetSearchIndexMultiGetCountBlock($data_result_keys) {
  $result_block = array();

  $i = 0;
  $each_block = array();
  foreach($data_result_keys as $each_data_result_key) {
    if($i == $GLOBALS["GET_SEARCH_INDEX_BLOCK_SIZE"]) {
      $result_block[] = $each_block;
      $i = 0;
    }
    if($i == 0) $each_block = array();

    $each_block[] = $each_data_result_key;

    $i++;
  }
  if(!empty($each_block)) $result_block[] = $each_block;

  return $result_block;
}

function GetSearchIndexMultiGetCount($data_result_keys) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $data_result_keys_block = GetSearchIndexMultiGetCountBlock($data_result_keys);

  $result = array();
  foreach($data_result_keys_block as $each_block) {
    $null_ary = array('getter_id' => 0);
    $each_data_count = MultiGetCountSearchText($null_ary, $each_block);
    //Debug("WARNING", __LINE__ . $DEBUG_FILENAME, "each_data_count", $each_data_count);
    //EchoDebug(true, false);
    $result += $each_data_count['result'];

    usleep($GLOBALS["GET_SEARCH_INDEX_USLEEP"]);
  }

  return $result;
}

$DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

if ($argc != 2 && $argc != 3) {
    echo "usage: GetSearchIndex.php [text] [prefix]\n";
    exit(0);
}

$text = $argv[1];
$prefix = isset($argv[2]) ? $argv[2] : '';
$params_search_text = array('prefix' => $prefix,
                            'sub_string_idx' => $text);
$key_id = SerializeKeySearchIndex($params_search_text);

$null_ary = array('getter_id' => 0);

//Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to GetSearchIndex: key_id", $key_id);

$data = GetCountSearchIndex($null_ary, $key_id);
//Debug("INFO-RESULT-COUNT", __LINE__ . $DEBUG_FILENAME, "data", $data);
echo "count: " . $data['result'] . "\n";

$n_data = $data['result'];

$data = GetSearchIndex($null_ary, $key_id, null, true, $n_data);
//Debug("INFO-RESULT", __LINE__ . $DEBUG_FILENAME, "data", $data);
//EchoDebug(true, false);

$data_result = $data['result'];
$data_result_keys = GetSearchIndexKeys($data_result, $prefix);

$data_count = GetSearchIndexMultiGetCount($data_result_keys);

//Debug("INFO-RESULT", __LINE__ . $DEBUG_FILENAME, "data_count", $data_count);
//EchoDebug(true, false);
print_r($data_count);
?>