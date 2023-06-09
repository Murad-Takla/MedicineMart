<?php 
// Include the database configuration file  
require_once 'dbcon.php'; 
 
$n=$_POST['n'];
$type=$_POST['type'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];

// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $insert = $db->query("INSERT into medicine (Medicine_Name,Medicine_Type,Medicine_Image,Medicine_Price,Quantity) VALUES ('$n','$type','$imgContent','$price','$quantity')"); 
             
            if($insert){ 
                $status = 'success'; 
                $statusMsg = "<h1>Medicine Added successfully.</h1>"; 
            }else{ 
                $statusMsg = "<h1>File upload failed, please try again.</h1>"; 
            }  
        }else{ 
            $statusMsg = '<h1>Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.</h1>'; 
        } 
    }else{ 
        $statusMsg = '<h1>Please select an image file to upload.</h1>'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>