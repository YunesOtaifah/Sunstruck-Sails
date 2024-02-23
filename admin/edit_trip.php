<?php
include "admin_header.php";
?>

<?php

if (isset($_GET['edit_trip_id'])) {
    $the_trip_id = $_GET['edit_trip_id'];


    $query = "SELECT * FROM trips WHERE id = ?";

    $select_trip_by_id = $pdo->prepare( $query);
    $select_trip_by_id->execute([$the_trip_id]);
    $trip = $select_trip_by_id->fetchAll();
    foreach($trip as $row){
        $trip_id=$row["id"];
        $trip_image=$row["trip_image"];
        $trip_title=$row["trip_title"];
        $trip_price=$row["trip_price"];
        $trip_status=$row["trip_status"];
        $trip_participants=$row["trip_participants"];
    }
}


if (isset($_POST['edit_trip'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $validation = [];

        $trip_title = isset($_POST['trip_title']) ? trim($_POST['trip_title']) : '';
        $trip_image = isset($_FILES['trip_image']['name']) ? trim($_FILES['trip_image']['name']) : '';
        $trip_price = isset($_POST['trip_price']) ? trim($_POST['trip_price']) : '';

        if (empty($trip_title)) {
            $validation['trip_title'] = 'Trip title is required.';
        }
        if (empty($trip_image)) {
            $query = "SELECT * FROM trips WHERE id = ?";

            $select_image_by_id = $pdo->prepare( $query);
            $select_image_by_id->execute([$the_trip_id]);
            $selected_image = $select_image_by_id->fetchAll();
            foreach($selected_image as $row){
                $trip_image=$row["trip_image"];
            }
        }

        if (empty($trip_price)) {
            $validation['trip_price'] = 'Trip price is required.';
        } elseif (!is_numeric($trip_price)) {
            $validation['trip_price'] = 'Trip price must be a decimal value.';
        } elseif ($trip_price < 0) {
            $validation['trip_price'] = "Trip price must be a positive number.";
        }

        if (empty($validation)) {
            $trip_image_temp = $_FILES['trip_image']['tmp_name'];
            move_uploaded_file($trip_image_temp, "../pictures/$trip_image");

            $query = "UPDATE trips SET trip_title = ?, trip_image = ?, trip_price = ? WHERE id = ?";

            $update_trip_query = $pdo->prepare($query);
            $update_trip_query->execute([$trip_title, $trip_image, $trip_price, $the_trip_id]);

            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo " <div class='alert alert-primary' role='alert'>Trip Updated Successfuly</div>";
        }
        //  else {
        //     // there are validation errors, display them
        //     foreach ($validation as $error) {
        //         echo "<div class='alert alert-danger' role='alert'>$error</div>";
        //     }
        // }
    }
}

?>



<body>
    <?php include "admin_nav.php"; ?>
    <br><br>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7 ">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Add Trip</h3>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="trip_title" class="col-sm-2 col-form-label">Trip Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="trip_title" name="trip_title"
                                            value="<?= isset($trip_title) ? $trip_title : '' ?>"
                                            placeholder="Trip Title">
                                        <?php if (isset($validation) && isset($validation['trip_title'])) { ?>
                                        <span class="text-danger"><?= $validation['trip_title'] ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="trip_price" class="col-sm-2 col-form-label">Trip Price</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="trip_price" name="trip_price"
                                            value="<?= isset($trip_price) ? $trip_price : '' ?>"
                                            placeholder="Trip Price">
                                        <?php if (isset($validation) && isset($validation['trip_price'])) { ?>
                                        <span class="text-danger"><?= $validation['trip_price'] ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="trip_image" class="col-sm-2 col-form-label">Trip Image</label>
                                    <div class="col-sm-10">
                                        <img width="100" src="../pictures/<?php echo $trip_image; ?>" alt="">
                                        <input type="file" class="form-control-file" id="trip_image" name="trip_image"
                                            accept="image/*">
                                        <?php if (isset($validation) && isset($validation['trip_image'])) { ?>
                                        <span class="text-danger"><?= $validation['trip_image'] ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" name="edit_trip" class="btn btn-primary">Update
                                            Trip</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</body>

<?php
include "admin_footer.php";
?>