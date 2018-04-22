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

});