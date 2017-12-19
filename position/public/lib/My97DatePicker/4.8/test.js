function start_time(id){
	WdatePicker({maxDate:'#F{$dp.$D(\''+id+'\')||\'%y-%M-{%d+14}\'}'});
}
function end_time(id){
	WdatePicker({ minDate:'#F{$dp.$D(\''+id+'\')}',maxDate:'#F{$dp.$D(\''+id+'\',{d:14});}' })
}
function search_time() {
	WdatePicker({ dateFmt: 'yyyy-MM', isShowToday: false, isShowClear: false });
}
