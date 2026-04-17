<?php
//  TODO: connect to the database 
require "includes/connect.php"; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// Make sure the user is logged in before they can access this page
require "includes/auth.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}
// access the form data and then echo on the page in a confirmation message

$imagetitle = filter_input(INPUT_POST, 'image_title', FILTER_SANITIZE_SPECIAL_CHARS);



 // this will store the image path for the database
$imagePath = null;

// validation time = serverside

$errors = [];

// require text field


if ($imagetitle === null || $imagetitle === '') {
    $errors[] = "Post Title is Required.";
}



//mcheck whether a file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        //make sure upload completed successfully 
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading your file!";
        } else {
            //only allow a few file types 
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            //detect the real MIME type of the file 
            $detectedType = mime_content_type($_FILES['image']['tmp_name']);
            if (!in_array($detectedType, $allowedTypes, true)) {
                $errors[] = "Only JPG, PNG and WebP allowed";
            } else {
                //build the file name and move it to where we want it to go (uploads)
                //get the file extension 
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                //create a unique filename so uploaded files don't overwrite 
                $safeFilename = uniqid('review_', true) . '.' . strtolower($extension);
                //build the full server path where the file will be stored 
                $destination = __DIR__ . '/uploads/' . $safeFilename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    //save the relative path to the database
                    $imagePath = 'uploads/' . $safeFilename; 
                } else {
                    $errors[] = "Image uploaded failed!"; 
                }
            }
        }
    }

if (!empty($errors)) {
    require "includes/header.php";   
    echo "<div class='alert alert-danger'>";
    echo "<h2>Please fix the following:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
       
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";

    require "includes/footer.php";
    exit;
}


// write an INSERT statement with named placeholders
$sql = "INSERT INTO images (title, image_path) values ( :image_title, :image_path)";

// prepare the statement
$stmt= $pdo->prepare($sql);

// map the named placeholder to the user data/actual data
$stmt->bindParam(':image_title', $imagetitle);
$stmt->bindParam(':image_path', $imagePath);

// execute the query
$stmt ->execute();

// close the connection
$pdo = null;
require "index.php";
?>




