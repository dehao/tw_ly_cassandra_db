<?php set_include_path(get_include_path() . PATH_SEPARATOR . '../../../../src/php-common'); /* 對應於 src/php-common 的 dir */ ?>
<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . 
                 $NoSQL['PHP_COMMON_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_CORE_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['IMPORT_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['IMPORT_PRIVATE_DIR'] . PATH_SEPARATOR . 
                 $NoSQL['API_DIR']
                 ); 
?>
<?php if($NoSQL['DEBUG']) include_once('Common/DebugArray.php'); ?>
<?php if($NoSQL['DEBUG']) include_once('Common/EchoDebug.php'); ?>
<?php include_once('Text/ImportTextToTextBasic.php'); ?>
<?php include_once('Common/WriteFile.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextToTextBasicUI
 * @memo (對於這個 function 的描述)
 *       (這個 function 做了哪些步驟)
 *
 * @param input                         (這個 function 的 input)
 *
 * @return result                       (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

$argc = count($argv);

if($argc != 3) {
    echo "usage: php ImportTextToTextBasicUI.php [filename] [prefix]\n";
    exit;
}

ImportTextToTextBasic($argv);

EchoDebug();

?>
