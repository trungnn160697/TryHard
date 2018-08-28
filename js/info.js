/**
 * @Project Module NUKEVIET 3.x
 * @Author PCD-Group (dinhpc.com)
 * @copyright 2010
 * @createdate 08/10/2011
 */

function clickcheckall(){
	$('#checkall').click(function(){
		if ( $(this).attr('checked') ){
			$('input:checkbox').each(function(){
				$(this).attr('checked','checked');
			});
		}else {
			$('input:checkbox').each(function(){
			$(this).removeAttr('checked');
			});
		}
	});
}

function delete_one(class_name,lang_confirm,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		if (confirm(lang_confirm))
		{
			var href= $(this).attr('href');
			$.ajax({	
				type: 'POST',
				url: href,
				data:'',
				success: function(data){				
					alert(data);
					if (url_back !='') {
						window.location=url_back;
					}
				}
			});
		}
	});
}

// delete all items select checkbox
function delete_all(filelist,class_name,lang_confirm,lang_error,url_del,url_back){
	$('a.'+class_name).click(function(event){
		event.preventDefault();
		var listall = [];
		$('input.'+filelist+':checked').each(function(){
			listall.push($(this).val());
		});
		if (listall.length<1){
			alert(lang_error);
			return false;
		}
		if (confirm(lang_confirm))
		{
			$.ajax({	
				type: 'POST',
				url: url_del,
				data:'listall='+listall,
				success: function(data){	
					window.location=url_back;
				}
			});
		}
	});
}
function ChangeActiveCat(idobject,catid,action){
	var value = $(idobject).val();
	$(idobject).attr('disabled', 'disabled');
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat_action&ac='+action,
		data:'catid='+catid + '&value='+value,
		success: function(data){
			$(idobject).removeAttr('disabled');
			if (data!='')
			{
				window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cat&parentid='+data
			}
		}
	});
}
function content_submit(status)
{
	$('#idstatus').val(status);
	$('#idcontent').submit();
}
function change_status(obj,status,id){
	var val = $(obj).val();
	$(obj).attr("disabled",true);
	$.ajax({	
		type: 'POST',
		url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=add&ac='+status+'&val='+val+'&id='+id,
		data:'',
		success: function(data){	
			$(obj).removeAttr("disabled");
		}
	});
}
function upnew(id){
	if (confirm("Báº¡n cĂ³ cháº¯c cháº¯n muá»‘n lĂ m má»›i time cá»§a file nĂ y?"))
	{
		$.ajax({	
			type: 'POST',
			url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&ac=upnew&id='+id,
			data:'',
			success: function(data){	
				window.location.reload(true);
			}
		});
	}
}
function change_overtime(obj){
	var val = $('#'+obj).val();
	if (val==2) $('#idover').show();
	else
		$('#idover').hide();
}

function show_group() {
	var igroup = $('#id_who_view').val();
	if ( igroup == 3 )
	{
		$('#id_groups_view').show();
	}
	else
	{
		$('#id_groups_view').hide();
	}
}
function get_alias() {
	var title = strip_tags(document.getElementById('idtitle').value);
	if (title != '') {
		$.ajax({	
			type: 'POST',
			url: script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=alias&title=' + encodeURIComponent(title),
			data:'',
			success: function(data){
				if (data != "") {
					document.getElementById('idalias').value = data;
				} else {
					document.getElementById('idalias').value = '';
				}
			}
		});
	}
	return false;
}

function search_ads()
{
	var catid = $('#catid').val();
	var q = $('#q_text').val();
	var s = $('#id_status').val();
	var c = $('#id_check').val();
	var or = $('#id_order').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&status='+s+'&check='+c+'&catid='+catid+'&order='+or+'&q='+encodeURIComponent(q);
	return false;
}

function search_logs() {
	var q = $('#idq').val();
	var year = $('#id_year').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=logs&year='+year+'&q='+encodeURIComponent(q);
}

function search_mega() {
	var q = $('#idq').val();
	var dt = $('#datetime').attr('checked') ? 1 : 0;
	var m = $('#id_month').val();
	var y = $('#id_year').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=mega&y='+y+'&m='+m+'&dt='+dt+'&q='+encodeURIComponent(q);
}
function search_lmega() {
	var q = $('#idq').val();
	var dt = $('#datetime').attr('checked') ? 1 : 0;
	var m = $('#id_month').val();
	var y = $('#id_year').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=lmega&y='+y+'&m='+m+'&dt='+dt+'&q='+encodeURIComponent(q);
}

function nv_add_otherimage()
{
   var newitem = "<tr><td align=\"right\">ID_"+file_items+"</td><td><input value=\"\" name=\"otherimage[]\" id=\"otherimage_" + file_items + "\" style=\"width : 50%\" maxlength=\"255\" />";
   newitem += "&nbsp;<input type=\"button\" value=\"" + file_selectfile + "\" name=\"selectfile\" onclick=\"nv_open_browse_file( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=otherimage_" + file_items + "&path=" + file_dir + "&type=file&currentpath="+currentpath+"', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /></td></tr>";
   $( "#otherimage" ).append( newitem );
   file_items ++ ;
}

function search_email() {
	var q = $('#idq').val();
	window.location = script_name+'?'+ nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=email&q='+encodeURIComponent(q);
}