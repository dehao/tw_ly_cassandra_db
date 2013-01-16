<?php include_once('Common/Debug.php'); ?>
<?php ?>
<?php
/**********
 * WriteFile
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param input             (這個 function 的 input)
 *
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function WriteFile($filename, $content, $is_write_file_true = false) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $dir = dirname($filename);
  
  if(!$is_write_file_true && (is_file($filename) || is_dir($filename))) {
    Debug("ERROR-FILE-EXISTS", $DEBUG_FILENAME, "filename", $filename);
    return;
  }

  if(is_file($dir)) {
    Debug("ERROR-DIR-IS_FILE", $DEBUG_FILENAME, "dir", $dir);
    return;
  }
  
  if(!is_dir($dir))
    mkdir($dir, 0755, true);

  Debug("INFO", $DEBUG_FILENAME, "to fwrite: dir: $dir filename: $filename content", $content);

  $f = fopen($filename, "w");
  fwrite($f, $content);
  fclose($f);

  return;
}
?>
