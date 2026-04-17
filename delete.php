<?php
/**
 * delete.php
 */

session_start();
// Make sure the user is logged in before they can access this page
require "includes/auth.php";

//connect to db
require "includes/connect.php";


// make sure we received an ID



if (!isset($_GET['id'])) {
  die("No image ID provided.");
}

$imgId = $_GET['id'];


// create the query 
$sql = "DELETE FROM images where id = :id";
//prepare 
$stmt = $pdo->prepare($sql);

//bind 
$stmt->bindParam(':id', $imgId);

//execute

$stmt->execute();


// Redirect back to admin list
header("Location: index.php");
exit;
