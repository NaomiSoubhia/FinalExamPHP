

<main>
    <h2 class="text-center mt-5">Upload New Image</h2>
    <form class="mt-4 " action="process.php" enctype="multipart/form-data" method="post">
        <div class="container d-flex justify-content-center ">
            <div class="row col-md-8 col-10">


                <div class="my-2">
                    <input type="text" class="form-control" name="image_title" id="image_title" placeholder="Image Title" aria-label="Image Title"
                        required>
                </div>


                <div class="col-md-12 col-10">
                <label for="review_image" class="form-label my-2">Image</label>
                <input
                    type="file"
                    id="review_image"
                    name="review_image"
                    class="form-control mb-4 my-2"
                    accept=".jpg,.jpeg,.png,.webp">
                </div>
                <div class="text-center mt-3 mb-2">
                    <button type="submit" class="btn btn-primary buttonForm ">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <h2 class="text-center mt-5 pb-3" id="images">Images</h2>
    <?php
    require __DIR__ . "/images_admin.php";

    ?>


</main>