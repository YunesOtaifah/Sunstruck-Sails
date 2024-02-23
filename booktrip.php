<?php require "includes/head.php"; ?>
<?php require "includes/dbcon.php"; ?>

<?php

if (isset($_SESSION['username'])) {
    $fname = $_SESSION['firstname'];
    $lname = $_SESSION['lastname'];
    $phone = $_SESSION['phonenumber'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];
} elseif (!isset($_SESSION['username']) and isset($_GET['trip_id'])) {
    header("Location: login.php?trip_id=" . $_GET['trip_id']);
}


if (isset($_POST['book_trip'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $validation = [];


        // First name validation
        if (!isset($_POST['fname']) || $_POST['fname'] === '') {
            $validation['fname'] = 'First name field is required.';
        } else {
            $firstname = trim($_POST['fname']);
        }

        // Last name validation
        if (!isset($_POST['lname']) || $_POST['lname'] === '') {
            $validation['lname'] = 'Last name field is required.';
        } else {
            $lname = $_POST['lname'];
        }
        if (!isset($_POST['boat_type']) || $_POST['boat_type'] === '') {
            $validation['boat_type'] = 'Boat Type field is required.';
        } else {
            $boat_type = $_POST['boat_type'];
        }

        if (!isset($_POST['trip']) || $_POST['trip'] === '') {
            $validation['trip'] = 'Destination field is required.';
        } else {
            $trip = $_POST['trip'];
        }


        if (!isset($_POST['starting_date']) || $_POST['starting_date'] === '') {
            $validation['starting_date'] = 'Start Date field is required.';
        } else {
            $starting_date = date_create_from_format('Y-m-d', $_POST['starting_date']);
            if (!$starting_date) {
                $validation['starting_date'] = 'Start Date must be a valid date.';
            } else {
                $now = new DateTime();
                if ($starting_date < $now) {
                    $validation['starting_date'] = 'Start Date must be a future date.';
                } else {
                    $starting_date = $_POST['starting_date'];
                }
            }
        }

        if (!isset($_POST['end_date']) || $_POST['end_date'] === '') {
            $validation['end_date'] = 'End Date field is required.';
        } else {
            $end_date = date_create_from_format('Y-m-d', $_POST['end_date']);
            if (!$end_date) {
                $validation['end_date'] = 'End Date must be a valid date.';
            } else {
                $now = new DateTime();
                if ($end_date < $now) {
                    $validation['end_date'] = 'End Date must be a future date.';
                } else if ($starting_date && $end_date < $starting_date) {
                    $validation['end_date'] = 'End Date must be after Start Date.';
                } else {
                    $end_date = $_POST['end_date'];
                }
            }
        }



        // Email validation
        if (!isset($_POST['email']) || $_POST['email'] === '') {
            $validation['email'] = 'Email address field is required.';
        } else {
            $valid = preg_match('/[0-z]+[@][0-z]+[.][A-z]+/', $_POST['email']) === 1;
            if (!$valid) {
                $validation['email'] = 'Email address must have a valid email format.';
            } else {
                $email = $_POST['email'];
            }
        }
    }


    if (!isset($_POST['num_of_adults']) || $_POST['num_of_adults'] === '') {
        $validation['num_of_adults'] = 'Number of adults is required.';
    } elseif (!ctype_digit($_POST['num_of_adults'])) {
        $validation['num_of_adults'] = 'Number of adults must be a Natural number.';
    } else {
        $num_of_adults = $_POST['num_of_adults'];
    }


    if (!isset($_POST['num_of_children']) || $_POST['num_of_children'] === '') {
        $validation['num_of_children'] = 'Number of children is required.';
    } elseif (!ctype_digit($_POST['num_of_children'])) {
        $validation['num_of_children'] = 'Number of children must be a Natural number.';
    } else {
        $num_of_children = $_POST['num_of_children'];
    }



    // License validation
    if (!isset($_POST['license']) || $_POST['license'] !== '1') {
        $validation['license'] = 'License agreement must be accepted.';
    } else {
        $license = $_POST['license'];
    }

    // Phone number validation
    if (!isset($_POST['phone']) || $_POST['phone'] == '') {
        $validation['phone'] = 'phone';
    } else {
        $phone = $_POST['phone'];
    }


    if (empty($validation)) {
        $query = $pdo->prepare('INSERT INTO book_trip (user_id, trip_id, fname, lname, email, starting_date , end_date, phone, num_of_adults, num_of_children, boat_type, license_accepted, verified) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1)');
        $result = $query->execute([$user_id, $trip, $fname, $lname, $email, $starting_date, $end_date, $phone, $num_of_adults, $num_of_children, $boat_type]);
        $query1 = "UPDATE trips SET trip_participants =trip_participants+1";
        $query1 .= " WHERE id = ?";
        $count_participants_query = $pdo->prepare($query1);
        $result2 = $count_participants_query->execute([$trip]);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo " <div class='alert alert-primary' role='alert'>Trip Booked Successfuly</div>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book trip</title>
    <link rel="icon" href="pictures\favicon (1).ico">

    <!-- css -->

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--   Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&family=Ubuntu:wght@300&display=swap" rel="stylesheet">

    <!--   Awesome fonts -->
    <script src="https://kit.fontawesome.com/de7c5bb96e.js" crossorigin="anonymous"></script>
</head>

<body>
    <br><br>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Book trip</h3>


                            <form action="booktrip.php" method="POST">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="fname">First Name</label>
                                            <input name="fname" type="text" id="fname" class="form-control form-control-lg" value="<?= isset($fname) ? $fname : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['fname'])) { ?>
                                                <span><?= $validation['fname'] ?></span>
                                            <?php   } ?>
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <label class="form-label" for="lname">Last Name</label>
                                            <input name="lname" type="text" id="lname" class="form-control form-control-lg" value="<?= isset($lname) ? $lname : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['lname'])) { ?>
                                                <span><?= $validation['lname'] ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>




                                <div class="row">

                                    <div class="col-md-6 mb-4 d-flex align-items-center">
                                        <div class="form-outline datepicker w-100">
                                            <label for="starting_date" class="form-label">Start date </label>
                                            <input name="starting_date" type="date" class="form-control form-control-lg" id="starting_date" value="<?= isset($starting_date) ? $starting_date : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['starting_date'])) { ?>
                                                <span><?= $validation['starting_date'] ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-4 d-flex align-items-center">
                                        <div class="form-outline datepicker w-100">
                                            <label for="end_date" class="form-label">End date </label>
                                            <input name="end_date" type="date" class="form-control form-control-lg" id="end_date" value="<?= isset($end_date) ? $end_date : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['end_date'])) { ?>
                                                <span><?= $validation['end_date'] ?></span>
                                            <?php  } ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label class="form-label" for="emailaddress">Email</label>
                                            <input name="email" type="email" id="emailaddress" class="form-control form-control-lg" value="<?= isset($email) ? $email : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['email'])) { ?>
                                                <span><?= $validation['email'] ?></span>
                                            <?php } ?>
                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label class="form-label" for="phone">Phone Number</label>
                                            <input name="phone" type="text" id="phone" class="form-control form-control-lg" value="<?= isset($phone) ? $phone : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['phone'])) {
                                            ?>
                                                <span><?= $validation['phone'] ?></span>
                                            <?php } ?>

                                        </div>

                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="num_of_adults">Number of adults</label>
                                            <input name="num_of_adults" type="text" id="num_of_adults" class="form-control form-control-lg" value="<?= isset($num_of_adults) ? $num_of_adults : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['num_of_adults'])) { ?>
                                                <span><?= $validation['num_of_adults'] ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="num_of_children">Number of children</label>
                                            <input name="num_of_children" type="text" id="num_of_children" class="form-control form-control-lg" value="<?= isset($num_of_children) ? $num_of_children : '' ?>" />
                                            <?php
                                            if (isset($validation) && isset($validation['num_of_children'])) { ?>
                                                <span><?= $validation['num_of_children'] ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label select-label">Chose boat type</label>
                                        <br>
                                        <select class="select form-control-lg" name="boat_type">
                                            <h6 class="mb-2 pb-1">Choose boat type </h6>
                                            <option value="1" disabled>Boats</option>
                                            <option value="Bavaria C45">Bavaria C45</option>
                                            <option value="Beneteau 46.1">Beneteau 46.1</option>
                                            <option value="Dufour 530 Grand Large">Dufour 530 Grand Large</option>
                                            <option value="Fountaine Pajot Isla 40">Fountaine Pajot Isla 40</option>
                                        </select>
                                        <?php
                                        if (isset($validation) && isset($validation['boat_type'])) { ?>
                                            <span><?= $validation['boat_type'] ?></span>
                                        <?php } ?>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label select-label">Choose destination</label>
                                        <br>
                                        <select class="select form-control-lg" name="trip">
                                            <h6 class="mb-2 pb-1">Choose destination </h6>

                                            <?php
                                            $query = $pdo->prepare("SELECT * FROM trips");
                                            $query->execute();
                                            $trip = $query->fetchAll();
                                            echo "<option value='1' disabled>Destination</option>";
                                            foreach ($trip as $row) {
                                                $trip_title = $row['trip_title'];
                                                $trip_id = $row['id'];
                                                echo "<option value='$trip_id'> $trip_title</option>";
                                            }
                                            ?>
                                        </select>
                                        <?php
                                        if (isset($validation) && isset($validation['trip'])) { ?>
                                            <span><?= $validation['trip'] ?></span>
                                        <?php } ?>
                                    </div>
                                </div>


                                <br>
                                <br>

                                <div class="col-md-6 mb-4 pb-2">
                                    <div class="form-outline">
                                        <label class="register-contianer">I accept the license agreement.
                                            <input type="checkbox" name="license" value="1" />
                                            <span class="checkmark"></span>
                                        </label>
                                        <?php
                                        if (isset($validation) && isset($validation['license'])) { ?>
                                            <span><?= $validation['license'] ?></span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="mt-4 pt-2">
                                    <input name="book_trip" class="btn btn-primary btn-lg" type="submit" value="Book A Trip" />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php require "includes/footer.php"; ?>