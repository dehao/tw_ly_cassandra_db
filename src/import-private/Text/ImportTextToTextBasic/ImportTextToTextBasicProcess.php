<?php include_once('Common/PhpCommonConstants.php'); ?>
<?php include_once('SearchRelated/AutoComplete/AutoCompleteCompile.php'); ?>
<?php include_once('AutoComplete/AutoCompleteText/MultiAddAutoCompleteText.php'); ?>
<?php include_once('AutoComplete/AutoCompleteIndex/MultiAddAutoCompleteIndex.php'); ?>
<?php include_once('SearchRelated/Search/SearchCompile.php'); ?>
<?php include_once('Search/SearchText/MultiAddSearchText.php'); ?>
<?php include_once('Search/SearchIndex/MultiAddSearchIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/UnserializeKeySearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnNameSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelated/SerializeColumnValueSearchRelated.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeKeySearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnNameSearchRelatedIndex.php'); ?>
<?php include_once('SearchRelated/SearchRelatedIndex/SerializeColumnValueSearchRelatedIndex.php'); ?>
<?php ?>
<?php
/**********
 * ImportTextToTextBasicProcess
 * @memo (對於這個 function 的描述)
 *     (這個 function 做了哪些步驟)
 *
 * @param params             (這個 function 的 input)
 *
 * @return is_error           是否有 error: 0: 沒有 erorr. 其他: 有 error.
 * 
 * @TODO (這個 function 的 todo)
 */

function ImportTextToTextBasicProcess(&$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;
  
  /**
   * text
   */

  $NoSQL["DEBUG"] = false;
  $params['filename'] = basename($params['filename']);

  $prefix = $params['prefix'];
  $text = $params['text'];
  $filename = $params['filename'];
  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "params", $params);

  $text_ary = ImportTextToTextBasicProcessTextAry($text);

  $count_text_ary = count($text_ary);

  foreach($text_ary as $each_text_key => $each_text) {
    $the_text = $each_text['the_text'];
    $the_start_line = $each_text['the_start_line'];

    /**
     * auto_complete_text
     */
    /*
      $compile = AutoCompleteCompile($text);
      $rows_compile = ImportTextToTextBasicProcessCompileText($compile, $prefix, $filename);
      $params = array('rows' => $rows_compile);
      MultiAddAutoCompleteText($params);
    */
    
    /**
     * auto_complete_index
     */
    /*
      $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile);
      $params = array('rows' => $rows_index_compile);
      MultiAddAutoCompleteIndex($params);
    */
    
    /**********
     * search_text
     */
    $is_first = $each_text_key == 0 ? true : false;
    $is_last = $each_text_key == ($count_text_ary - 1) ? true : false;
    $compile = SearchCompile($the_text, $the_start_line);
    //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "compile", $compile);
    //$NoSQL["_debug"] = "";
    //EchoDebug();
    $compile_block = ImportTextToTextBasicProcessCompileBlock($compile);
    foreach($compile_block as $each_compile_block) {
      $rows_compile = ImportTextToTextBasicProcessCompileText($each_compile_block, $prefix, $filename, $params, $the_start_line, $is_first, $is_last);
      //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "rows_compile", $rows_compile);
      //$NoSQL["_debug"] = "";
      //EchoDebug(true, false);
      if(empty($rows_compile)) continue;

      $params_search_text = array('rows' => $rows_compile);

      $the_end_i = $GLOBALS["IMPORT_RETRY"];
      for($i = 0; $i < $GLOBALS["IMPORT_RETRY"]; $i++) {
        $data = MultiAddSearchText($params_search_text);
        if(!$data['error']) {
          $the_end_i = $i;
          break;
        }
        Debug("ERROR_IMPORT", __LINE__ . $DEBUG_FILENAME, "data", $data);
        EchoDebug(true, false);
        usleep($GLOBALS["IMPORT_TIME_USLEEP"]);
      }
      if($the_end_i == $GLOBALS["IMPORT_RETRY"]) {
        Debug("ERROR_IMPORT_RETRY", __LINE__ . $DEBUG_FILENAME, "import failed: params_search_text", $params_search_text);
        EchoDebug(true, false);
      }
        
      $NoSQL["_debug"] = "";
      
      /**********
       * search_index
       */
      $rows_index_compile = ImportTextToTextBasicProcessCompileIndex($rows_compile, $params);
      //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "rows_index_compile", $rows_index_compile);
      $NoSQL["_debug"] = "";
      //EchoDebug();
      $params_search_index = array('rows' => $rows_index_compile);

      $the_end_i = $GLOBALS["IMPORT_RETRY"];
      for($i = 0; $i < $GLOBALS["IMPORT_RETRY"]; $i++) {
        $data = MultiAddSearchIndex($params_search_index);
        if(!$data['error']) {
          $the_end_i = $i;
          break;
        }
        Debug("ERROR_IMPORT", __LINE__ . $DEBUG_FILENAME, "data", $data);
        EchoDebug(true, false);
        usleep($GLOBALS["IMPORT_TIME_USLEEP"]);
      }
      if($the_end_i == $GLOBALS["IMPORT_RETRY"]) {
        Debug("ERROR_IMPORT_RETRY", __LINE__ . $DEBUG_FILENAME, "import failed: params_search_index", $params_search_index);
        EchoDebug(true, false);
      }
      
      $NoSQL["_debug"] = "";
    }
    
    /**********
     * return
     */
  }

  return 0;
}

function ImportTextToTextBasicProcessCompileBlock($compile) {
  $compile_block = array();
  $n_each_block = 0;
  $n_block = 0;
  $mem_size = 0;
  foreach($compile as $each_compile) {
    $mem_size_each_compile = strlen(serialize($each_compile));
    $mem_size += $mem_size_each_compile;
    if($mem_size >= $GLOBALS["COMPILE_BLOCK_MEM_SIZE"]) {
      $mem_size = $mem_size_each_compile;
      $n_block++;
    }
    $compile_block[$n_block][] = $each_compile;
  }

  return $compile_block;
}

function ImportTextToTextBasicProcessCompileText($compile, $prefix, $filename, $params, $start_line, $is_first, $is_last) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($compile as $each_compile) {
    $the_row = $each_compile['the_row'];
    if(!$is_first && $the_row < $start_line + $GLOBALS["SEARCH_RELATED_CONTEXT_N_PREFIX"]) continue;
    if(!$is_last && $the_row >= $start_line + $GLOBALS["BLOCK_N_LINES"]) continue;

    //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "the_row: $the_row");
    $key = ImportTextToTextBasicProcessCompileTextKey($each_compile, $prefix, $params);
    $column_name = ImportTextToTextBasicProcessCompileTextColumnName($each_compile, $prefix, $filename, $params);
    $params['column_name_id_format'] = FormatKeyString($column_name);
    $column_value = ImportTextToTextBasicProcessCompileTextColumnValue($each_compile, $prefix, $filename, $params);
    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }
  return $rows;
}

function ImportTextToTextBasicProcessCompileTextKey($each_compile, $prefix, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related = array('prefix' => $prefix,
                                 'sub_string' => $each_compile['sub_string']);
  $result = SerializeKeySearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessCompileTextColumnName($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $search_related_id = $filename;
  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : "";
  $the_col = isset($each_compile['the_col']) ? $each_compile['the_col'] : "";
  $score = ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, $params);
  $params_search_related = array('search_related_id' => $search_related_id,
                                 'the_row' => $the_row,
                                 'the_col' => $the_col,
                                 'score' => $score
    );
  $result = SerializeColumnNameSearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessCompileTextColumnValue($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $column_name_id_format = isset($params['column_name_id_format']) ? $params['column_name_id_format'] : "";
  $the_timestamp = isset($params['the_timestamp']) ? $params['the_timestamp'] : "";
  $context = isset($each_compile['context']) ? $each_compile['context'] : "";
  $search_related_id = $filename;
  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : "";
  $the_col = isset($each_compile['the_col']) ? $each_compile['the_col'] : "";
  $score = ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, $params);
  
  $params_search_related = array('column_name_id_format' => $column_name_id_format,
                                 'the_timestamp' => $the_timestamp,
                                 'context' => $context,
                                 'search_related_id' => $search_related_id,
                                 'the_row' => $the_row,
                                 'the_col' => $the_col,
                                 'score' => $score,
                                 'info' => '');
  $result = SerializeColumnValueSearchRelated($params_search_related);
  return $result;
}

function ImportTextToTextBasicProcessScore($each_compile, $prefix, $filename, &$params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $the_row = isset($each_compile['the_row']) ? $each_compile['the_row'] : 0;
  $the_row = sprintf("%04d", $the_row);

  $filename = preg_replace("/\\..*/u", "", $filename); 

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "after replace (no postfix): filename: $filename");
  $filename_digit_ary = preg_split("/-/u", $filename); 

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "filename_digit_ary", $filename_digit_ary);

  $score = "";
  $is_first = true;
  foreach($filename_digit_ary as $each_filename_digit) {
    if($is_first) $is_first = false; else $score .= "-";
    $score .= sprintf("%04d", $each_filename_digit);
  }
  $score .= "-" . $the_row;

  //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "score", $score);

  return $score;
}

function ImportTextToTextBasicProcessCompileIndex($rows_compile, $params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $rows = array();
  foreach($rows_compile as $each_key => &$each_val) {
    $each_key_st = UnserializeKeySearchRelated($each_key);
    
    $sub_string = $each_key_st['sub_string'];
    $str_len = mb_strlen($sub_string);
    $idx = ($str_len == 1) ? $GLOBALS["SEARCH_RELATED_INDEX_DEFAULT_KEY"] : mb_substr($sub_string, 0, $str_len - 1);

    $key = ImportTextToTextBasicProcessCompileIndexKey($each_key_st['prefix'], $idx);
    $column_name = ImportTextToTextBasicProcessCompileIndexColumnName($each_key_st['sub_string'], $params);
    $params['column_name_id_format'] = FormatKeyString($column_name);
    $column_value = ImportTextToTextBasicProcessCompileIndexColumnValue($each_key_st['sub_string'], $params);

    if(!isset($rows[$key])) $rows[$key] = array();
    $rows[$key][$column_name] = $column_value;
  }

  return $rows;
}

function ImportTextToTextBasicProcessCompileIndexKey($prefix, $idx) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('prefix' => $prefix,
                                       'sub_string_idx' => $idx);
  $result = SerializeKeySearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnName($sub_string, $params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $params_search_related_index = array('sub_string' => $sub_string);

  $result = SerializeColumnNameSearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessCompileIndexColumnValue($sub_string, $params) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $column_name_id_format = isset($params['column_name_id_format']) ? $params['column_name_id_format'] : "";
  $the_timestamp = isset($params['the_timestamp']) ? $params['the_timestamp'] : "";
  $sub_string = $sub_string;
  
  $params_search_related_index = array('column_name_id_format' => $column_name_id_format,
                                       'the_timestamp' => $the_timestamp,
                                       'sub_string' => $sub_string,
                                       'info' => '');
  $result = SerializeColumnValueSearchRelatedIndex($params_search_related_index);
  return $result;
}

function ImportTextToTextBasicProcessTextAry($text) {
  global $NoSQL;
  $DEBUG_FILENAME = '#' . __FILE__ . '@' . __FUNCTION__;

  $lines = preg_split("/\n/smu", $text);
  $n_lines = count($lines);

  $start_line = 0;

  $text_ary = array();
  while(true) {
    $end_line = min($start_line + $GLOBALS["BLOCK_N_LINES"] + $GLOBALS["SEARCH_RELATED_CONTEXT_N_POSTFIX"], $n_lines);

    //Debug("INFO", __LINE__ . $DEBUG_FILENAME, "", "start_line: $start_line end_line: $end_line");
    //EchoDebug(true, false);

    $each_text = "";
    for($i = $start_line; $i < $end_line; $i++) $each_text .= $lines[$i] . "\n";

    $text_ary[] = array('the_text' => $each_text,
                        'the_start_line' => $start_line);

    $start_line = $start_line + $GLOBALS["BLOCK_N_LINES"] - $GLOBALS["SEARCH_RELATED_CONTEXT_N_PREFIX"];
    if($start_line >= $n_lines) break;
  }

  return $text_ary;
}

?>
