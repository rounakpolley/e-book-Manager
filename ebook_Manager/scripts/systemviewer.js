$(document).ready(function(){

	$('#system-viewer').width(($('#main_body').width())-($('#pdf-viewer').width())-2);
	
	var tab = 1;				//  1=files 2=catalogues
	$('#files').addClass('show');
	$('#files-tab').addClass('selected-tab');
	$('#file-modal-contents').css('display','block');
	$('#catalogue-modal-contents').css('display','none');

	$('#files-tab').click(function(){
		tab = 1;
		$('#files-tab').addClass('selected-tab');
		$('#catalogues-tab').removeClass('selected-tab');
		$('#files').addClass('show');
		$('#catalogues').removeClass('show');
		$('#file-modal-contents').css('display','block');
		$('#catalogue-modal-contents').css('display','none');
	});

	$('#catalogues-tab').click(function(){
		tab = 2;
		$('#files-tab').removeClass('selected-tab');
		$('#catalogues-tab').addClass('selected-tab');
		$('#files').removeClass('show');
		$('#catalogues').addClass('show');
		$('#catalogue-modal-contents').css('display','block');
		$('#file-modal-contents').css('display','none');
	});

	$('.download-icon').click(function(evt){
		var rel_path = $(this).parent().attr('file_path');
		evt.stopPropagation();
		window.open('php/download_file.php?file_path='+rel_path, '_blank');
		//console.log(rel_path);
		//php/download_file.php?file_path='
		//var error = rel_path + " : Not available for download";
		//alert(error);
	});
	$('[id^=catalogue-no-].panel-group > div').click(function(evt){
		$('[id^=catalogue-no-].panel-group > div').removeClass('panel-danger');
		$('[id^=catalogue-no-].panel-group > div').addClass('panel-warning');
		$(this).removeClass('panel-warning');
		$(this).addClass('panel-danger');

		selected_catalog_id = $(this).parent().attr('id');
		console.log(selected_catalog_id);

		//selected-catalogue-id
		$('#selected-catalogue-id').val(selected_catalog_id);
		//slit this string to extract catalogue id for inserting into database
	});
});