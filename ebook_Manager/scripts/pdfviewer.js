$(document).ready(function(){

	var pdf = null;
	var rotation = 1;			//1 = normal + 90 = 2 + 90 = 3 (inverted) + 90 = 4 + 90 = 1
	var num_of_pages = 0;
	var zoom_level = 1.6;
	var path = "";
	var file_open = false;

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

	//$('[id^=file_]');
	$('[id^=file_]').click(function(evt){
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

	document.getElementById("make-note").onclick = function(){
		//log % scroll
		if(file_open){
			var doc_scroll = $("#pdf-viewer").scrollTop();
			var doc_height = ($('canvas').height())*num_of_pages;
			var doc_per = (doc_scroll/doc_height)*100;
			console.log("scrollPercent :",doc_per," %");
			document.getElementById("notes-drawer").style.width = "24.5vw";
		}
	}
	//#pdf-viewer
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
});
