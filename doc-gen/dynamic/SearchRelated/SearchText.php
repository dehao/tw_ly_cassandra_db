<?php 
///////////
/// SearchText
/// @memo <ul>
/// <li>common_dynamic:   <ul><li>[中文(傳統)] 所有 dynamic 的共同基本資訊 (不能直接把 search_id 放在這裡的 key. 因為有 system_all.</li></ul>
/// </li>
/// <li>search_related:   <ul><li>[中文(傳統)] search 相關的 list</li></ul>
/// </li>
/// <li>search:   <ul><li>[中文(傳統)] search 相關的 list</li></ul>
/// </li>
/// <li>search_text:   <ul><li>[中文(傳統)] search 相關的 list</li></ul>
/// </li></ul>
/// @param [base_type] common_dynamic
/// @param [base_type] search_related
/// @param [base_type] search
/// @param [key] prefix                                               <ul><li>type: string</li><li>[中文(傳統)] search 的 sub_string</li></ul>
/// @param [key] sub_string                                           <ul><li>type: string</li><li>[中文(傳統)] search 的 sub_string</li></ul>
///
/// @param [column_name] score                                        <ul><li>type: string</li><li>[中文(傳統)] score</li></ul>
/// @param [column_name] text_id                                      <ul><li>type: key</li><li>[中文(傳統)] 相對應的 text id</li></ul>
/// @param [column_name] the_row                                      <ul><li>type: string</li><li>[中文(傳統)] 相對應的 row</li></ul>
/// @param [column_name] the_col                                      <ul><li>type: string</li><li>[中文(傳統)] 相對應的 col</li></ul>
///
/// @param [column_value] column_name_id_format                       <ul><li>type: string</li><li>require: false</li><li>[中文(傳統)] column_name_id 給 browser/client 端的 format</li></ul>
/// @param [column_value] the_timestamp                               <ul><li>type: string</li><li>[中文(傳統)] 加入這個 list 的時間</li></ul>
/// @param [column_value] context                                     <ul><li>type: string</li><li>[中文(傳統)] context</li></ul>
/// @param [column_value] score                                       <ul><li>type: string</li><li>[中文(傳統)] score</li></ul>
/// @param [column_value] text_id                                     <ul><li>type: key</li><li>[中文(傳統)] 相對應的 text id</li></ul>
/// @param [column_value] the_row                                     <ul><li>type: string</li><li>[中文(傳統)] 相對應的 row</li></ul>
/// @param [column_value] the_col                                     <ul><li>type: string</li><li>[中文(傳統)] 相對應的 col</li></ul>
/// @param [column_value] info                                        <ul><li>type: json_array</li><li>[中文(傳統)] 其他以 json_array 形式表示的資訊</li></ul>
///
/// @param [related_function] AddCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] AddPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] AddDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] AddLimitedLengthCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] AddLimitedLengthPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] AddLimitedLengthDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddLimitedLengthCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddLimitedLengthPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiAddLimitedLengthDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] GetCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] GetPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] GetDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiGetCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiGetPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiGetDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemoveCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemovePreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemoveDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemoveLeastScoreCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemoveLeastScorePreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] RemoveLeastScoreDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiRemoveLeastScoreCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiRemoveLeastScorePreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] MultiRemoveLeastScoreDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] CalcScoreCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] CalcScorePreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] CalcScoreDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] TestCheckParams
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] TestPreprocess
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [related_function] TestDealWith
///                                                                   <ul>
///                                                                   <li>common_dynamic<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_related<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   <li>search_text<ul>
///                                                                   <li>?></li>
///                                                                   </ul></li>
///                                                                   </ul>
/// @param [cf_info] <ul><li>CF => search_text</li><li>SET_CF => search_text</li><li>SECOND_CF => text</li><li>SET_SECOND_CF => text</li><li>COUNT_CF => search</li><li>SET_COUNT_CF => search</li><li>COUNT_COLUMN => text</li><li>LENGTH => 100</li></ul>
///////////
function SearchTextAjax() {
}
?>
