<?php set_include_path(get_include_path() . PATH_SEPARATOR . 'src/php-common'); ?>
<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . 
                 $NoSQL['PHP_COMMON_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_CORE_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_DIR']
                 ); 
?>
<?php include_once('Search/SearchText/SerializeKeySearchText.php'); ?>
<?php include_once('Search/SearchText/GetSearchText.php'); ?>
<?php include_once('Search/SearchText/GetCountSearchText.php'); ?>
<?php
$DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

if ($argc != 2 && $argc != 3) {
    echo "usage: GetSearchText.php [text] [prefix]\n";
    exit(0);
}

$text = $argv[1];
$prefix = isset($argv[2]) ? $argv[2] : '';
$params_search_text = array('prefix' => $prefix,
                            'sub_string' => $text);
$key_id = SerializeKeySearchText($params_search_text);

$null_ary = array('getter_id' => 0);

Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to GetSearchText: key_id", $key_id);

$data = GetCountSearchText($null_ary, $key_id);
Debug("INFO-RESULT-COUNT", __LINE__ . $DEBUG_FILENAME, "data", $data);

$n_data = $data['result'];

$data = GetSearchText($null_ary, $key_id);
Debug("INFO-RESULT", __LINE__ . $DEBUG_FILENAME, "data", $data);
EchoDebug(true);
?>