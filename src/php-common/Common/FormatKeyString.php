<?php ?>
<?php
/**********
 * FormatKeyString
 * @memo
 * @param input             (這個 function 的 input)
 * @return result             (這個 function 的 result)
 * 
 * @TODO (這個 function 的 todo)
 */

function FormatKeyString($str_unenc, $cassandra_type = null) {
  global $NoSQL;
  $DEBUG_FILENAME = "#" . __FILE__ . "@" . __FUNCTION__;

  $str_unenc_st = JsonDecode($str_unenc);
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "str_unenc: $str_unenc str_unenc_st", $str_unenc_st);
  if($str_unenc_st === null) {
    //Debug("WARNING", __LINE__ . $DEBUG_FILENAME, "", "str_unenc: $str_unenc: str_unenc_st === null: return str_unenc");
    return $str_unenc;
  }
  if(!is_array($str_unenc_st)) {
    //Debug("INFO", $DEBUG_FILENAME, "" "str_unenc: $str_unenc: str_unenc_st: $str_unenc_st: return str_unenc");
    return $str_unenc;
  }

  $str_enc = "";
  $is_first = true;
  foreach($str_unenc_st as $each_str_unenc) {
    if($is_first) $is_first = false; else $str_enc .= "_";
    $each_str_enc = $each_str_unenc;
    $str_enc .= $each_str_enc;
  }

  //Debug("INFO-END", $DEBUG_FILENAME, "", "str_unenc: $str_unenc str_enc: $str_enc");
  return $str_enc;
}
?>
