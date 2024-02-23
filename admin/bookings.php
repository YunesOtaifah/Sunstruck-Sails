<div id="bookings" class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <!-- <!-- <?php //if(isset($_SESSION['message'])) : 
                        ?> -->
            <!-- <h5 class="alert alert-success"><?php //$_SESSION['message']; 
                                                    ?></h5> -->
            <?php
            // unset($_SESSION['message']);
            //endif; 
            ?>
            <div class="card">
                <div class="card-header">
                    <h3>Bookings</h3>
                </div>

                <div class="card-body">
                    <table class="table table-border table-striped">
                        <thead>
                            <tr>
                                <th>Trip</th>
                                <th>Participant</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Adults</th>
                                <th>Children</th>
                                <th>Boat</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = 'SELECT * FROM book_trip';
                            $select_all_bookings = $pdo->prepare($query);
                            $select_all_bookings->execute();

                            $bookings = $select_all_bookings->fetchAll();

                            foreach ($bookings as $row) {
                                $id = $row["id"];
                                $trip_id = $row["trip_id"];
                                $user_id = $row["user_id"];
                                $fname = $row["fname"];
                                $lname = $row["lname"];
                                $email = $row["email"];
                                $phone = $row["phone"];
                                $starting_date = $row["starting_date"];
                                $end_date = $row["end_date"];
                                $num_of_adults = $row["num_of_adults"];
                                $num_of_children = $row["num_of_children"];
                                $boat_type = $row["boat_type"];

                                $booking_trip_query = 'SELECT * FROM trips WHERE id= ?';
                                $select_trip = $pdo->prepare($booking_trip_query);
                                $select_trip->execute([$trip_id]);
                                $booking_trip = $select_trip->fetchAll();
                                foreach ($booking_trip as $row) {
                                    $trip_title = $row['trip_title'];
                                }


                                $user_fullname = $fname . ' ' . $lname;

                                echo "<tr>";
                                echo "<td>{$trip_title}</td>";
                                echo "<td>{$user_fullname}</td>";
                                echo "<td>{$email}</td>";
                                echo "<td>{$phone}</td>";
                                echo "<td>{$num_of_adults}</td>";
                                echo "<td>{$num_of_children}</td>";
                                echo "<td>{$boat_type}</td>";
                                echo "<td>{$starting_date}</td>";
                                echo "<td>{$end_date}</td>";
                                echo "<td><a href='edit_booking.php?edit_booking_id={$id}'><button class='btn btn-primary'>Edit</button></a></td>";
                                echo "<td><a href='index.php?delete_booking_id={$id}'><button class='btn btn-danger'>Delete</button></a></td>";
                                echo "</tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php


if (isset($_GET['delete_booking_id'])) {

    $the_booking_id = $_GET['delete_booking_id'];
    $query = "DELETE FROM book_trip WHERE id = ? ";
    $delete_query = $pdo->prepare($query);
    $delete_query->execute([$the_booking_id]);

    header("Location: index.php");
}

?>