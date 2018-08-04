<?php
session_start();
require_once("../../checklogin.php");
check_login();	
include('../../dbconnection.php');
?>

<?php
//header("Location: ../index.php");

//Note Upload.
$user_id=$_SESSION['id'];
//echo "$user_id<br>";


if (isset($_POST['new-note-name'])) 
{
	$note_name = $_POST['new-note-name'];
	$cat_id = $_POST['selected-catalogue-id'];
	$catalogue_id_str = substr($cat_id,(strlen($cat_id)-1));
	$catalogue_id = (int)$catalogue_id_str;
	echo "$catalogue_id<br>";
	$canvas_orientation = $_POST['canvas-orientation'];
	echo "$canvas_orientation<br>";
	$scroll_percentage = $_POST['scroll-percentage'];
	echo "$scroll_percentage<br>";
	$selected_file_path = $_POST['selected-file-path'];

echo "$selected_file_path  file path";

 
	if(isset($_SESSION['id']))
	{
				
				$sql = "INSERT INTO notes(user_id,catalogue_id,rel_file_path,note_name,canvas_orientation,scroll_percentage) VALUES ('$user_id','$catalogue_id','$selected_file_path','$note_name','$canvas_orientation','$scroll_percentage')";
						if(mysqli_query($con,$sql))
						{
							echo "Insert Successfully.";
						}
						else
						{
							echo "Insert Unsuccessfully.";
						}			
	}
}



//Note Text Upload

if (isset($_POST['new-note-text'])) 
{
	$note_text = $_POST['new-note-text'];

	if(isset($_SESSION['id']))
	{
				//$user_id=$_SESSION['id'];
				//echo "$user_id<br>";
				
				$sql2 = "UPDATE notes SET note_text = '$note_text' WHERE user_id = '$user_id' AND note_name= '$note_name' AND catalogue_id = '$catalogue_id'";
						if(mysqli_query($con,$sql2))
						{
						echo "Insert Successfully.";
						}
						else
						{
						echo "Insert Unsuccessfully.";
						}			
	}
}


//Note Link Upload

if (isset($_POST['new-note-links'])) 
{
	$note_link = $_POST['new-note-links'];

	if(isset($_SESSION['id']))
	{
				//$user_id=$_SESSION['id'];
				//echo "$user_id<br>";
				
				$sql3 = "UPDATE notes SET note_links = '$note_link' WHERE user_id = '$user_id' AND note_name= '$note_name' AND catalogue_id = '$catalogue_id'";
						if(mysqli_query($con,$sql3))
						{
						echo "Insert Successfully.";
						}
						else
						{
						echo "Insert Unsuccessfully.";
						}			
	}
}


if (isset($_FILES['new-note-images']) && $_FILES['new-note-images'] != null) 
{
	$targetfolder = "../note_images/";
  	$myFile = $_FILES['new-note-images'];
    $fileCount = count($myFile["name"]);
            
	$ok=1;


	//Limiting the file types / Uploading images with PHP script

	for($i=0;$i<$fileCount;$i++)
	{
 		$targetfile = $targetfolder . basename( $_FILES['new-note-images']['name'][$i]) ;
		$file_type=$_FILES['new-note-images']['type'][$i];

		if ($file_type== "image/gif" OR $file_type== "image/png" OR $file_type== "image/jpeg" OR $file_type== "image/JPEG" OR $file_type== "image/PNG" OR $file_type== "image/GIF")
		{

 			if(move_uploaded_file($_FILES['new-note-images']['tmp_name'][$i], $targetfile))
			{
				echo "The file ". basename( $_FILES['new-note-images']['name'][$i]). " is uploaded<br><br>";


 				//To insert files in database.
				if(isset($_SESSION['id']))
				{
					//$user_id=$_SESSION['id'];
					$file_name=basename( $_FILES['new-note-images']['name'][$i]);
					$rel_file_path=$targetfile;


					$sql4 = "SELECT * FROM notes WHERE user_id = '$user_id' AND note_name= '$note_name' AND catalogue_id = '$catalogue_id'";
					$result = mysqli_query($con,$sql4);
					$row = mysqli_fetch_assoc($result);
					if(is_null($row["note_images_paths"]))
					{
						$file_path = $rel_file_path;
					}
					else
					{
						$file_path = $row["note_images_paths"].';'.$rel_file_path;
						$rel_file_path = $file_path;
					}
					


					$sql5 = "UPDATE notes SET note_images_paths = '$rel_file_path' WHERE user_id = '$user_id' AND note_name= '$note_name' AND catalogue_id = '$catalogue_id'";
					if(mysqli_query($con,$sql5))
					{
						echo "Insert Successfully.";
					}
					else
					{
						echo "Insert Unsuccessfully.";
					}			
				}			
				//SQL disconnected after all else statements.
			}
			else 
			{
			echo "Problem uploading file";
			}
		}
		else 
		{
 			echo "You may only upload image files.";
		}
	}
}


unset($_POST['new-note-name']);
unset($_POST['new-note-text']);
unset($_POST['new-note-links']);
unset($_FILES['new-note-images']);
unset($_POST['selected-catalogue-id']);
unset($_POST['canvas-orientation']);
unset($_POST['scroll-percentage']);
mysqli_close($con);
echo '<script type="text/javascript">window.close()</script>';
?>