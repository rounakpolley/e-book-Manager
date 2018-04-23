$(document).ready(function(){

	var pdf = null;
	var rotation = 1;			//1 = normal + 90 = 2 + 90 = 3 (inverted) + 90 = 4 + 90 = 1
	var num_of_pages = 0;
	var zoom_level = 1.6;
	var path = "";
	var selected_catalog_id = "";
	var selected_bookmark_id = "";
	var file_open = false;
	var catalogue_open = false;

	function return_orientation(){
		return rotation;
	}

	function renderPage(num){
		//pdf global var
			pdf.getPage(num)
			.then(function(page) {
				var canvasId = 'pdf_viewer-' + num;
				//check if canvas element exists
				if(!document.getElementById(canvasId)){
					$('#pdf-viewer').append($('<canvas/>', {'id': canvasId}));
				}
				
				var canvas = document.getElementById(canvasId);
				var scale = zoom_level;
			    var viewport = page.getViewport(scale);
			    var context = canvas.getContext('2d');
			    canvas.height = viewport.height;
				canvas.width = viewport.width;
				// Prepare object needed by render method
				var renderContext = {
  					canvasContext: context,
  					viewport: viewport
				};
				// Render PDF page
				//console.log('page : ',num);
				page.render(renderContext);
			});
	};
	
	var arrange_pages = function(){
		var promise = new Promise(function(resolve, reject){
  			//console.log("arranging");
			$("#pdf-viewer canvas").sort(function (a, b){
					var aid = a.id.split("-")[1];
					var bid = b.id.split("-")[1];
				    return parseInt(aid) > parseInt(bid);
			}).each(function(){
				    var elem = $(this);
				    elem.remove();
				    $(elem).appendTo("#pdf-viewer");
			});
		});
		return promise;
	};
	
	var renderAllPages = function(){
		var promise = new Promise(function(resolve, reject){
			//console.log('rendering :',num_of_pages);
  			for (var i = 1; i <= num_of_pages; i++){
  				renderPage(i);
 			}
		});											//console.log(promise);
		return promise;
	};
	
	function displayDocument(param_r, param_n, param_z, param_p){
		rotation = param_r;
		num_of_pages = param_n;
		zoom_level = param_z;
		path = param_p;
    	PDFJS.getDocument(path)
    	.then(function (pdfDoc_){
    		//setting global vars
        	pdf = pdfDoc_;
        	num_of_pages = pdf.numPages;
      	})
      	.then(function(){
      		renderAllPages()//.then(arrange_pages());
			});
	};
	

	function ValidURL(str){
		console.log(str);
		var pattern = new RegExp('^(https?:\/\/)?'+ // protocol
		    '((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|'+ // domain name
		    '((\d{1,3}\.){3}\d{1,3}))'+ // OR ip (v4) address
		    '(\:\d+)?(\/[-a-z\d%_.~+]*)*'+ // port and path
		    '(\?[;&a-z\d%_.~+=-]*)?'+ // query string
		    '(\#[-a-z\d_]*)?$','i'); // fragment locater
	  	if(!pattern.test(str)){
	    	//alert("Please enter a valid URL.");
	    	return false;
	  	}
	  	else{
	    	return true;
	  	}
	}
	function isUrl(s) {
		var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	   	return regexp.test(s);
	}
	$('#new-note-links').keydown(function(evt){
		var keycode = (evt.keyCode ? evt.keyCode : evt.which);
		if(keycode == 13){
			var check = true;
			urls = $('#new-note-links').val().split("\n");
			for(var i = 0; i <= urls.length-1; i++){
				var tmp = isUrl(urls[i]);
				if(tmp == false){
					alert("Enter valid url");
					check = false;
					break;
				}
			}
			if(check){
				$('#new-note-links').css('text-decoration','underline');
				$('#new-note-links').css('color','blue');
			}
			else{
				$('#new-note-links').css('text-decoration','none');
				$('#new-note-links').css('color','inherit');
			}
		}
	});



	
	$('[id^=file_]').click(function(evt){
		//$('pdf-viewer-info').addClass('hidden');
		$('#pdf-viewer').addClass('gif-loading');
		$('canvas').remove();
		file_open = false;
		//--- now open
		var relative_path = $(this).attr("file_path");
		//console.log(relative_path);
		displayDocument(1, 0, 1.6, relative_path);
		file_open = true;
		
	});

	document.getElementById("zoom-in").onclick = function(){
		if(file_open){
			var prev = $('canvas').width();
			$('canvas').width(prev + 10);
			//console.log('in');	//zoom_level += 0.1;	//displayDocument();	
		}
	}
	document.getElementById("zoom-out").onclick = function(){
		if(file_open){
			var prev = $('canvas').width();
			$('canvas').width(prev - 10);
			//console.log('in');	//zoom_level -= 0.1;	//displayDocument();	
		}	
	}

	document.getElementById("rotate").onclick = function(){
		if(file_open){
			//rotate contents of div or change axis
			var h = $('canvas').height();
			var w = $('canvas').width();
			//$('canvas').height(w);
			//$('canvas').width(h);
			var margin = -((h-w)/2);
			margin1 = margin.toString() + "px";
			margin2 = ((margin*2)+1).toString() + "px";

			switch(rotation){
	    		case 1 :{
					$('canvas').css("transform", "rotate(90deg)");
					$('canvas').css("margin-top", margin2);
					$('canvas').css("margin-bottom", margin1);	
					$('#pdf_viewer-1').css("margin-top", margin1);
					rotation = 2;
	    			break;		
	    		}
	    		case 2 :{
					$('canvas').css("transform", "rotate(180deg)");
					$('canvas').css("margin-top", "auto");
					$('canvas').css("margin-bottom", "auto");
					rotation = 3;
	    			break;		
	    		}
	    		case 3 :{
					$('canvas').css("transform", "rotate(270deg)");
					$('canvas').css("margin-top", margin2);
					$('canvas').css("margin-bottom", margin1);	
					$('#pdf_viewer-1').css("margin-top", margin1);
					rotation = 4;
	    			break;		
	    		}
	    		case 4 :{
					$('canvas').css("transform", "rotate(0deg)");
					$('canvas').css("margin-top", "auto");
					$('canvas').css("margin-bottom", "auto");
					rotation = 1;
	    			break;		
	    		}
			}	
		}
	}
	
	function get_scroll_percentage(){
		var doc_scroll = $("#pdf-viewer").scrollTop();
		if(doc_scroll == 0){
			doc_scroll = 1;
		}
		var doc_height = ($('canvas').height())*num_of_pages;
		var doc_per = (doc_scroll/doc_height)*100;
		//console.log("scrollPercent :",doc_per," %");
		return doc_per;
	}

	function scroll_to_percentage(note_percentage){
		//console.log(note_percentage);
		var doc_height = ($('canvas').height())*num_of_pages;
		console.log(doc_height);
		var scroll_to = note_percentage * doc_height * 0.01;
		console.log(scroll_to);
		$("#pdf-viewer").scrollTop(scroll_to);
	}
	document.getElementById("make-note").onclick = function(){
		//log % scroll
		if(file_open){
			$('#show-catalogue-note').addClass('hidden');
			$('#new-note-form').removeClass('hidden');
			//-------------------------------- comment next line later function meant to be called from php
			scroll_percentage = get_scroll_percentage();
			//---- next line is only for testing purposes
			console.log(scroll_percentage);
			document.getElementById("notes-drawer").style.width = "24.5vw";
		}
		else{
			alert("Open an e-book first!");
		}
	}
	//comment next line later
	catalogue_open = true;
	document.getElementById("open-note").onclick = function(){
		//------- next line for testing
		scroll_to_percentage(76.111111111111114);
		if(catalogue_open){
			$('#new-note-form').addClass('hidden');
			$('#show-catalogue-note').removeClass('hidden');
			document.getElementById("notes-drawer").style.width = "24.5vw";
		}
	}

	document.getElementById("notes-close").onclick = function(){
		document.getElementById("notes-drawer").style.width = "0";
	}

	//-------------- also check the range of scroll to show the blinking button
	//--------------------------------------------------------------------------------
	if(catalogue_open){
		$('#open-note').removeClass('hidden');

		var cycle = 1;
		setInterval(function(){
			switch(cycle){
				case 1:{
					cycle = 2;
					$('#open-note').css('-webkit-filter',"grayscale(20%)");
					$('#open-note').css('filter',"grayscale(20%)");
					break;
				}
				case 2:{
					cycle = 1;
					$('#open-note').css('-webkit-filter',"grayscale(0%)");
					$('#open-note').css('filter',"grayscale(0%)");
					break;
				}
			}
		}, 250);
	}

	//scroll using arrow keys
	$('body').keydown(function(evt){
		var keycode = (evt.keyCode ? evt.keyCode : evt.which);
		//console.log(keycode);
		if(keycode == 38){
			var curr_scroll = $("#pdf-viewer").scrollTop();
			curr_scroll -= 20;
			$("#pdf-viewer").scrollTop(curr_scroll);
		}
		else if(keycode == 40){
			var curr_scroll = $("#pdf-viewer").scrollTop();
			curr_scroll += 20;
			$("#pdf-viewer").scrollTop(curr_scroll);
		}
	});

	$('[id^=catalogue-no-].panel-group > div').click(function(evt){
		$('[id^=catalogue-no-].panel-group > div').removeClass('panel-danger');
		$('[id^=catalogue-no-].panel-group > div').addClass('panel-warning');
		$(this).removeClass('panel-warning');
		$(this).addClass('panel-danger');

		selected_catalog_id = $(this).parent().attr('id');
		console.log(selected_catalog_id);
		//slit this string to extract catalogue id for inserting into database
	});

	$('[id^=bookmark]').click(function(evt){
		file_open = true;
		catalogue_open = true;
		$('#pdf-viewer').addClass('gif-loading');
		$('canvas').remove();
		$('[id^=bookmark]').removeClass('list-group-item-warning');
		$(this).addClass('list-group-item-warning');
		selected_bookmark_id = $(this).attr('id');
		console.log(selected_bookmark_id);
		//---- next line is only for testing purposes
		scroll_to_percentage(26.111111111111114);
	});

});
//catalogue-'.$row['catalogue_id'].'-contents