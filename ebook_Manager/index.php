<?php
session_start();
include("../checklogin.php");
check_login();	
include('../dbconnection.php');
?>

<?php 
	$id = $_SESSION['id'];
	echo $id;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>e-Book Manager</title>
	<link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
	
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
			<div class="dropdown">
				<img id="settings" src="icons/gear.png" type="button" aria-haspopup="true" aria-expanded="true"
					class="floating-action-button dropdown-toggle" data-toggle="dropdown" ><!--dropdown-->
				<ul id="settings-dropdown" class="dropdown-menu" aria-labelledby="settings">
				    <li><a href="#"><span id="settings-username"><?php echo $_SESSION['name'];?></span></a></li>
					<li><a href="#"><span id="settings-changePassword">Change Password</span></a></li>
				    <li><a href="../logout.php"><span id="settings-logout">Logout</span></a></li>
				    <li role="separator" class="divider"></li>
				    <li><a href="#"><span id="settings-help">Help</span></a></li>
				    <li><a href="#"><span id="settings-exit">Exit</span></a></li>
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

						<!--jQuery add and remove list-group-item-success class
					  	<a id="file-holder-no-1" href="javascript:void(0)" value="files/gw.pdf" 
					  		class="list-group-item list-group-item-success">
							<img src="icons/file.png" class="file-icon">
					  		<span id="file-no-1">File that is open</span>
						</a>-->


						<!-- Creating File List From Database.-->
						<?php
							$sql = "SELECT * FROM files where user_id = $id";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_assoc($result))
							{
								echo '<a href="javascript:void(0)" ';
								echo 'file_path="'.$row['rel_file_path'].'" class="list-group-item">';
								echo '<img src="icons/file.png" class="file-icon">';
								echo '<span id="'.$row['file_id'].'">'.$row['file_name'].'</span></a>';
		
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
				<!--<div id="catalogues-show">
					<div id="catalogues-no-1" class="panel-group">
		                <div class="panel panel-default panel-success">
		                    <div  data-toggle="collapse" href="#catalogues-1-contents" class="panel-heading">
		                        <h5 class="panel-title">
									<img src="icons/folder.png" class="folder-icon">
		                        	<span id="catalogue-no-1">Catalogue name1</span> &nbsp; <span class="caret"></span>
		                        </h5>
		                    </div>
		                    <div id="catalogues-1-contents" class="panel-collapse collapse">
		                        <ul class="list-group">
		                            <li class="list-group-item">
										<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-1">Bookmark name1</span>
		                            </li>
		                            <li class="list-group-item">
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-2">Bookmark No. 2</span>
		                            </li>
		                            <li class="list-group-item">
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-3">Remove panel-success class from all cateloges only with one that is currently open on click</span>
		                            </li>
		                        </ul>
		                    </div>
		                </div>
		            </div> -->


		            
		            <!-- Creating Catalogue List From Database.-->
						<?php
							$sql = "SELECT * FROM catalogues where user_id = $id";
							$result = mysqli_query($con,$sql);
							while($row = mysqli_fetch_assoc($result))
							{
								
								echo '<div id="catalogues-no-'. $row['catalogue_id'] .'" class="panel-group">';
		                		echo '<div class="panel panel-default panel-success">';
		                    	echo '<div  data-toggle="collapse" href="#catalogues-1-contents" class="panel-heading">';
		                        echo '<h5 class="panel-title">';
								echo '<img src="icons/folder.png" class="folder-icon">';
		                        echo '<span id="catalogue-no-1">"'.$row['catalogue_name'].'"</span> &nbsp; <span class="caret"></span>';
		                        echo '</h5>';
		                    	echo '</div>';
		                    	echo '<div id="catalogues-1-contents" class="panel-collapse collapse">';
		                    	?>
		                        <ul class="list-group">
		                            <li class="list-group-item">
										<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-1">Bookmark name1</span>
		                            </li>
		                            <li class="list-group-item">
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-2">Bookmark No. 2</span>
		                            </li>
		                            <li class="list-group-item">
		                            	<img src="icons/bookmark.png" class="folder-icon">
		                            	<span id="bookmark-no-3">Remove panel-success class from all cateloges only with one that is currently open on click</span>
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
		<img id="zoom-in"   class="floating-action-button" src="icons/plus.png">
		<img id="zoom-out"  class="floating-action-button" src="icons/minu.png">
		<img id="make-note" class="floating-action-button" src="icons/pen.png">
		<img id="rotate"    class="floating-action-button" src="icons/rotate.png">
	</div>

	<div id="notes-drawer" class="sidenav">
	  	<a href="javascript:void(0)" class="closebtn" id="notes-close">&times;</a>
	  	<!-- do it -->
        <form action="" method="post" enctype="multipart/form-data" id="new-note-form">
            <div style="padding-left: 20px;">
                <h3 style="color: white">Make a new note <br/><small>to be added to the current catalogue</small></h3>
                <input id="new-note-name" name="new-note-name" class="note-form-content" type="text"
                       placeholder="Note Name" value="default : Note no.1"
                       style="width: 18vw;"/><br/><br/>
                <!-- generate a default value from php -->
                <textarea id="new-note-text" name="new-note-text" class="note-form-content" 
                          placeholder="Jot down notes.." style="width: 18vw;"></textarea><br/>
                <textarea id="new-note-links" name="new-note-links" class="note-form-content" 
                       type="url" placeholder="Enter each link in separate line"
                          style="overflow-x: auto; white-space: nowrap; width: 18vw;"></textarea><br/>
                <h5 style="color: white">Upload images with note</h5>
                <input id="new-note-images" name="new-note-images" class="note-form-content" 
                       style="width: 18vw; color: white;"
                       type="file" style="color: white;" multiple /><br/>
                <button type="submit" value="submit-note" id="submit-note" name="submit-note" 
                        style="margin-left: 10vw;"
                        class="btn btn-warning">Make Note</button>
            </div>
        </form>
	</div>
<?php 
mysqli_close($con);
?>
</body>
</html>