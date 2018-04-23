<?php
session_start();
include("../checklogin.php");
check_login();	
include('../dbconnection.php');
?>

<?php 
	$id = $_SESSION['id'];
	//echo $id;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>e-Book Manager</title>
	<link href="../favicon.ico" rel="shortcut icon" type="image/x-icon">
	
	<link rel="stylesheet" href="cdn/bootstrap3.3.7.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="cdn/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="cdn/bootstrap3.3.7.min.js"></script>

	<script type="text/javascript" src="pdfjs/build/pdf.js"></script>
	<script type="text/javascript" src="pdfjs/build/pdf.worker.js"></script>
	
	<link rel="stylesheet" type="text/css" href="styles/dashboard.css">
	<link rel="stylesheet" type="text/css" href="styles/systemviewer.css">
	<link rel="stylesheet" href="styles/pdfviewer.css" type="text/css">

	<script type="text/javascript" src="scripts/index.js"></script>
	<script type="text/javascript" src="scripts/pdfviewer.js"></script>
	<script type="text/javascript" src="scripts/systemviewer.js"></script>
	
</head>
<body id="main_body">
	
	<div id="system-viewer">

		<div id="system-header">
			<img src="graphics/logo.png" style="height: 40px; margin-top: -7px;"/>
			<div class="dropdown"><!--$_SESSION['name'];-->
				<img id="settings" src="icons/gear.png" type="button" aria-haspopup="true" aria-expanded="true"
					class="floating-action-button dropdown-toggle" data-toggle="dropdown" ><!--dropdown-->
				<ul id="settings-dropdown" class="dropdown-menu" aria-labelledby="settings">
				    <li style="width: 140px; overflow-x: hidden;">
				    	<a href="#"><span id="settings-username"><?php echo $_SESSION['login']?></span></a></li>
					<li><a href="#" onclick="alert('This is under dev')"><span id="settings-changePassword">Change Password</span></a></li>
				    <li><a href="../logout.php"><span id="settings-logout">Logout</span></a></li>
				    <li role="separator" class="divider"></li>
				    <li><a target="blank" href="help.html"><span id="settings-help">Help</span></a></li>
				    <!--<li ><a href="../index.php"><span id="settings-exit">Exit</span></a></li>-->
				    <!-- unable to exit properly -->
			  	</ul>
			</div>
		</div>

		<div class="tab">
		  <button id="files-tab" class="tablinks">FILES</button>
		  <button id="catalogues-tab" class="tablinks">CATALOGUES</button>
		</div>
		<div id="tabview">
			<div id="files" class="tabcontent">
				<div id="files-search" class="input-group" style="padding-bottom: 7px;">
		      		<input type="text" class="form-control" placeholder="Search files">
		      		<span class="input-group-btn">
		        		<button class="btn btn-default" type="button">
		        			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		        		</button>
		      		</span>
		    	</div>
		    	<div id="files-show">
					<div class="list-group">
						<!--Showing files form database-->
						<?php
							$sql = "SELECT * FROM files where user_id = $id";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_assoc($result))
							{
								echo '<a id="file_'.$row['file_id'].'" href="javascript:void(0)" ';
								echo 'file_path="'.$row['rel_file_path'].'" class="list-group-item">';
								echo '<img src="icons/file.png" class="file-icon">';
								echo '<span>'.$row['file_name'].'</span></a>';
		
							}
						?>
					</div>
		    	</div>
			</div>
			<div id="catalogues" class="tabcontent">
				<div id="catalogues-search" class="input-group" style="padding-bottom: 7px;">
		      		<input type="text" class="form-control" placeholder="Search catalogues">
		      		<span class="input-group-btn">
		        		<button class="btn btn-default" type="button">
		        			<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
		        		</button>
		      		</span>
		    	</div>
		            <!-- Creating Catalogue List From Database.-->
						<?php
							$sql = "SELECT * FROM catalogues where user_id = $id";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_assoc($result))
							{
								
								echo '<div id="catalogue-no-'.$row['catalogue_id'].'" class="panel-group">';
		                		echo '<div class="panel panel-default panel-warning">';
		                    	echo '<div  data-toggle="collapse" href="#catalogue-'.$row['catalogue_id'].'-contents" class="panel-heading">';
		                        echo '<h5 class="panel-title">';
								echo '<img src="icons/folder.png" class="folder-icon">';
		                        echo '<span id="catalogue-no-'.$row['catalogue_id'].'">'.$row['catalogue_name'].'</span> &nbsp; <span class="caret"></span>';
		                        echo '</h5>';
		                    	echo '</div>';
		                    	echo '<div id="catalogue-'.$row['catalogue_id'].'-contents" class="panel-collapse collapse">';
		                    	?>
		                    	<!-- this part yet to be done by php -->
		                    	<!-- id of li elements = bookmark-x-catalogue-y x & y are nos. -->
		                        <ul class="list-group">
		                            <?php echo '<li id="bookmark-1-catalogue-'.$row['catalogue_id'].'" class="list-group-item">'; ?>
										<img src="icons/bookmark.png" class="folder-icon">
		                            	<span>Bookmark name1</span>
		                            </li>
		                            <?php echo '<li id="bookmark-2-catalogue-'.$row['catalogue_id'].'" class="list-group-item">'; ?>
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-2-catalogue-'.$row['catalogue_id'].'">Bookmark No. 2</span>
		                            </li>
		                            <?php echo '<li id="bookmark-3-catalogue-'.$row['catalogue_id'].'" class="list-group-item">'; ?>
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-3-catalogue-'.$row['catalogue_id'].'">
		                            		Remove panel-success class from all cateloges only with one that is currently open on click</span>
		                            </li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
		            <?php
							}
						?>


				</div>
			</div>
		</div>
		
		<div class="dropup">
			<img id="new-file-catalogue" class="floating-action-button dropdown-toggle" src="icons/add.png"  type="button"  		data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  	<ul id="file-catalogue-modal" class="dropdown-menu" aria-labelledby="new-file-catalogue">
		  		<form action="upload.php" method="post" enctype="multipart/form-data" id="new-file-catalogue-form">
		  			<div id="file-modal-contents">
			  			<h4>Upload e-books</h4>
			  			<input type="file" id="fileToUpload" name="fileToUpload[]" multiple 
                               style="width: 240px;"  /><!--see notes-->
			  		</div>
			  		<div id="catalogue-modal-contents">
			  			<h4>Create a new Catalogue</h4>
			  			<input type="text" id="new-catalogue-name" name="new-catalogue-name" 
                               placeholder="Catalogue name" style="width: 250px;" ><br/>
			  			<br/>
			  			<textarea id="new-catalogue-desc" name="new-catalogue-desc" 
                                  placeholder="Description ..." style="width: 250px;" ></textarea>
			  		</div><br/>
			  		<button type="submit"  id="upload_file-create_catalogue" name="upload_file-create_catalogue" 
                            class="btn btn-success" style="float: right;">Done</button>
		  		</form>
		  	</ul>
		</div>
	</div>

	<div id="pdf-viewer">
		<!--<h4 id="pdf-viewer-info">Open an e-book or Catalogue-note</h4>-->
		<img id="zoom-in"   class="floating-action-button" src="icons/plus.png">
		<img id="zoom-out"  class="floating-action-button" src="icons/minu.png">
		<img id="make-note" class="floating-action-button" src="icons/pen.png">
		<img id="rotate"    class="floating-action-button" src="icons/rotate.png">
		<img id="open-note" class="floating-action-button hidden"  src="icons/note.png">
	</div>

	<div id="notes-drawer" class="sidenav">
	  	<a href="javascript:void(0)" class="closebtn" id="notes-close">&times;</a>
	  	<!-- do it -->
        <form action="" method="post" enctype="multipart/form-data" id="new-note-form" class="hidden">
            <div style="padding-left: 20px;">

                <h3 style="color: white">Make a new note <br/><small>to be added to the current catalogue</small></h3>
                <input id="new-note-name" name="new-note-name" class="note-form-content" type="text"
                       placeholder="Note Name" value="default : Note no.1"
                       style="width: 18vw;"/><br/><br/>
                <!-- generate a default value from php -->
                <textarea id="new-note-text" name="new-note-text" class="note-form-content" 
                          placeholder="Jot down notes.." style="width: 18vw; height: 150px; overflow: auto;"></textarea>
                          <br/><br/>
                <textarea id="new-note-links" name="new-note-links" class="note-form-content" 
                       type="url" placeholder="Enter each link in separate line"
                          style="overflow-x: auto; white-space: pre; width: 18vw; height: 70px;"></textarea><br/>
                <h5 style="color: white">Upload images with note</h5>
                <input id="new-note-images" name="new-note-images" class="note-form-content" 
                       style="width: 18vw; color: white;"
                       type="file" style="color: white;" multiple /><br/>
                <button type="submit" value="submit-note" id="submit-note" name="submit-note" 
                        style="margin-left: 10vw;"
                        class="btn btn-warning">Make Note</button><br/><br/>
            </div>
        </form>
        <div id="show-catalogue-note" class="hidden">
        	<!-- render it's contents from php -->
        	<div style="padding-left: 30px; color: white; width: 22vw;">
        		<h4 id="notes-view-name">Note Name</h4>
        		<hr id="notes-view-hr" style="margin: 0px 0px 5px 0px"/>
        		<p id="notes-view-text" style="height: 300px; overflow-y: auto;">
        			Note text or note details that user had entered<br/><br/>
        			This notes view is only opened when user is viewing a note from a catalogue
        			The blinking notes icon (yellow) will only appear when a note/bookmark from catalogues pannel is clicked and it will stay there for a scroll range of +,- 200px<br/>
        			User can also add additional notes to a catalogue while it is selected
        			<strong>This follows variable no of links &amp; images That one in new tabs</strong>
        			<br/><br/><br/><br/><br/><br/>Eureka!!!
        		</p>
        		<div id="notes-view-links"><!-- put the middle part of url like "mangarock.com" in <a> -->
        			<h6>External Links</h6>
        			<a target="blank" href="https://stackoverflow.com/questions/33063213/pdf-js-with-text-selection">stackoverflow.com</a>
        			<a target="blank" href="https://mangarock.com/manga/mrs-serie-295440/chapter/mrs-chapter-295442">mangarock.com</a>
        		</div>
        		<div id="notes-view-images"><!-- here put the file name of image in <a> -->
        			<h6>Attached Images</h6>
        			<a target="blank" href="graphics/logo.png">logo</a>
        			<a target="blank" href="graphics/icon.png">icon</a>
        		</div>
        	</div>
        </div>
	</div>
<?php 
mysqli_close($con);
?>
</body>
</html>