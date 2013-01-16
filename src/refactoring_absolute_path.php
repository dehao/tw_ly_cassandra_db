<?php set_include_path(get_include_path() . PATH_SEPARATOR . '../src/php-common'); ?>
<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . 
                 $NoSQL['PHP_COMMON_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_CORE_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_DIR'] 
                 ); 
?>
<?php
$NoSQL["INCLUDE_PATH"] = array(
        $NoSQL['PHP_COMMON_DIR'],
        $NoSQL['API_CORE_DIR'],
        $NoSQL['API_DIR']
        );

function ParseFullPath($filename) {
    global $NoSQL;
    $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

    foreach($NoSQL["INCLUDE_PATH"] as $each_path) {
        $tmp_filename = $each_path . "/" . $filename;
        if(is_file($tmp_filename)) return $tmp_filename;
    }
    return $filename;
}

$DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

$filename = $argv[1];
$content = file_get_contents($filename);
$content = trim($content);

//Debug("INFO", __LINE__ . $DEBUG_FILENAME, "content", $content);
$match_ary = array();
$str = "";
while(preg_match("/(.*?)_once\\('(.*?)'\\)(.*)/smu", $content, $match_ary)) {
    $prefix = $match_ary[1];
    $infix = $match_ary[2];
    $postfix = $match_ary[3];

    $str .= $prefix . "_once('";

    $str .= ParseFullPath($infix);

    $content = "')" . $postfix;
}
$str .= $content;

//EchoDebug();

echo $str . "\n";


?>
