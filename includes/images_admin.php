<?php
//TODO:
require "includes/connect.php";

session_start();
// Make sure the user is logged in before they can access this page
require "includes/auth.php";

//1. Write a SELECT query 
$sql = "SELECT * FROM images order by image_date desc";

//2. Prepare the statement
$stmt = $pdo->prepare($sql);


//4. Execute the statement
$stmt->execute();

$images = []; // placeholder

$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Close the connection
$pdo = null;


?>


<?php if (count($images) > 0): ?>
    <?php foreach ($images as $img): ?>
        <div class="container mx-auto text-center pt-2 bg-light rounded col-md-8 my-5 py-5" id="images">
            <div class="text-end">
                <a class="col-1" href="delete.php?id=<?= urlencode($p['id']); ?>"
                    onclick="return confirm('Are you sure you want to delete?');"><img class="mt-4 pe-2 col-1" src="images/trash.png" alt=""></a>
              
            </div>
            <div class="py-3">

                <?php if (!empty($img['image_path'])): ?>
                    <img src="<?= htmlspecialchars($img['image_path']); ?>" class="rounded w-50 d-block mx-auto " alt="Post Image">

                <?php else: ?>
                    <p>No image found</p>
                <?php endif; ?>

            </div>
            <h3 class="text-capitalize py-3"><?= htmlspecialchars($img['title']) ?></h3>
            
        </div>
    <?php endforeach; ?>

<?php endif; ?>