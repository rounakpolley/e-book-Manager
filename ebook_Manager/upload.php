<?php

 $targetfolder = "files/";

 $targetfolder = $targetfolder . basename( $_FILES['fileToUpload']['name']) ;

if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetfolder))

 {

 echo "The file ". basename( $_FILES['fileToUpload']['name']). " is uploaded";

 }

 else {

 echo "Problem uploading file";

 }

 ?>