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
<?php
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

Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to GetSearchIndex: key_id", $key_id);

$data = GetCountSearchIndex($null_ary, $key_id);
Debug("INFO-RESULT-COUNT", __LINE__ . $DEBUG_FILENAME, "data", $data);

$n_data = $data['result'];

$data = GetSearchIndex($null_ary, $key_id);
Debug("INFO-RESULT", __LINE__ . $DEBUG_FILENAME, "data", $data);
EchoDebug(true);
?>