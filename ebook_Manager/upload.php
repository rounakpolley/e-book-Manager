<?php
session_start();
require_once("../checklogin.php");
check_login();	
include('../dbconnection.php');
?>

<?php
header("Location: index.php");
	
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload'] != null) 
{
				$targetfolder = "files/";
                $myFile = $_FILES['fileToUpload'];
                $fileCount = count($myFile["name"]);
            

  $ok=1;


//Limiting the file types / Uploading images with PHP script

for($i=0;$i<$fileCount;$i++)
{
 $targetfile = $targetfolder . basename( $_FILES['fileToUpload']['name'][$i]) ;


$file_type=$_FILES['fileToUpload']['type'][$i];

if ($file_type=="application/pdf") {

 if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$i], $targetfile))

 {

 echo "The file ". basename( $_FILES['fileToUpload']['name'][$i]). " is uploaded<br><br>";


 				//To insert files in database.
				if(isset($_SESSION['id'])){
				$user_id=$_SESSION['id'];
				echo "$user_id<br>";
				$file_name=basename( $_FILES['fileToUpload']['name'][$i]);
				echo "$file_name<br>";
				$rel_file_path=$targetfile;
				echo "$rel_file_path<br>";
				$sql = "INSERT INTO files(user_id,file_name,rel_file_path) values('$user_id','$file_name','$rel_file_path')";
						if(mysqli_query($con,$sql)){
						echo "Insert Successfully.";							
						}
						else{
								echo "Insert Unsuccessfully.";	
						}			
				//SQL disconnected after all else statements.
				}

 }

 else {
	echo "Problem uploading file";

 }

}

else {
 
	echo "You may only upload PDF files.";

}
}

	echo "The file is uploaded";
}


//Catalog Upload.

if (isset($_POST['new-catalogue-name']) && $_POST['new-catalogue-name'] != "") 
{
	$catalogue_name = $_POST['new-catalogue-name'];
	$catalogue_description = $_POST['new-catalogue-desc'];
	if(isset($_SESSION['id'])){
				$user_id=$_SESSION['id'];
				echo "$user_id<br>";
				
				$sql = "INSERT INTO catalogues(user_id,catalogue_name,catalogue_description) values('$user_id','$catalogue_name','$catalogue_description')";
						if(mysqli_query($con,$sql)){
						echo "Insert Successfully.";
						}else{
						echo "Insert Unsuccessfully.";
						}			
				//SQL disconnected after all else statements.
				}


}

//SQL database disconnected here.
unset($_FILES['fileToUpload']);
unset($_POST['new-catalogue-name']);
mysqli_close($con);
?>