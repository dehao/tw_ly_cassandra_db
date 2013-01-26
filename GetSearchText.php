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
<?php include_once('Search/SearchText/UnserializeColumnNameSearchText.php'); ?>
<?php include_once('Search/SearchText/GetCountSearchText.php'); ?>
<?php

function GetSearchTextProcessData(&$data, $dir) {
  $data_result = $data['result'];

  $data_result = array_reverse($data_result);

  $the_output = array();

  foreach($data_result as $each_column_name => &$each_column_val) {
    $each_column_name_st = UnserializeColumnNameSearchText($each_column_name);
    $filename = $each_column_name_st['text_id'];
    $the_row = $each_column_name_st['the_row'];
    $the_row_start = $the_row + 1 - $GLOBALS["GET_SEARCH_TEXT_CONTEXT_N_PREFIX_LINE"];
    $the_row_start = max($the_row_start, 1);

    $the_row_end = $the_row_start + $GLOBALS["GET_SEARCH_TEXT_CONTEXT_N_LINE"] - 1;


    $full_filename = $dir . "/" . $filename;
    $cmd = "sed -n " . $the_row_start . "," . $the_row_end . "p " . $full_filename;
    $each_output = array();
    exec($cmd, $each_output);
    $the_output[$filename . "_" . $the_row] = $each_output;
  }
  print_r($the_output);
}

function GetSearchTextProcessColStart($start_id) {
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $start_id_ary = preg_split("/\.txt_/smu", $start_id);
  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "start_id_ary", $start_id_ary);

  $filename = $start_id_ary[0];
  $line_no = $start_id_ary[1];

  $filename_st = explode("-", $filename);
  $format = $GLOBALS["DIGIT_FORMAT"] . "-" . $GLOBALS["DIGIT_FORMAT"] . "-" . $GLOBALS["DIGIT_FORMAT"] . "-" . $GLOBALS["DIGIT_FORMAT"] . "-" . $GLOBALS["DIGIT_FORMAT"];
  $score = sprintf($format, $filename_st[0], $filename_st[1], $filename_st[2], $filename_st[3], $line_no);

  $result = "[\"" . $score . "\",\"" . $filename . ".txt\",\"" . $line_no . "\",\"\"]";

  Debug("INFO", __LINE__ . $DEBUG_FILENAME, "result", $result);

  return $result;
}


$DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

if ($argc < 2 || $argc > 7) {
    echo "usage: GetSearchText.php [text] [prefix] [n_context_lines] [data_dir] [is_all_data] [start_id]\n";
    exit(0);
}

$text = $argv[1];
$prefix = isset($argv[2]) ? $argv[2] : '';
$n_context_lines = isset($argv[3]) ? $argv[3] : $GLOBALS["GET_SEARCH_TEXT_CONTEXT_N_LINE"];
$data_dir = isset($argv[4]) ? $argv[4] : 'data';
$is_all_data = isset($argv[5]) && $argv[5] == "true" ? true : false;
$col_start = isset($argv[6]) ? GetSearchTextProcessColStart($argv[6]) : "";

$params_search_text = array('prefix' => $prefix,
                            'sub_string' => $text);

$GLOBALS["GET_SEARCH_TEXT_CONTEXT_N_LINE"] = $n_context_lines;
$GLOBALS["GET_SEARCH_TEXT_CONTEXT_N_PREFIX_LINE"] = ($n_context_lines - 1) / 2;

$key_id = SerializeKeySearchText($params_search_text);

$null_ary = array('getter_id' => 0);

//Debug("INFO", __LINE__ . $DEBUG_FILENAME, "to GetSearchText: key_id", $key_id);

$data = GetCountSearchText($null_ary, $key_id);
echo "count: " . $data['result'] . "\n";
//Debug("INFO-RESULT-COUNT", __LINE__ . $DEBUG_FILENAME, "data", $data);

$n_data = $is_all_data ? $data['result'] : LENGTH_GET_DATA;

//Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "to GetSearchText: key_id: $key_id n_data: $n_data col_start: $col_start");
$data = GetSearchText($null_ary, $key_id, null, true, $n_data, $col_start);
//Debug("INFO-RESULT", __LINE__ . $DEBUG_FILENAME, "data", $data);
EchoDebug(true, false);

GetSearchTextProcessData($data, $data_dir);

?>