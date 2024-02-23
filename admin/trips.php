<div id="trips" class="container">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>Trips
                        <a href="index.php?unactivate_all=true" class="btn btn-danger float-end mx-2">Unactivate All</a>
                        <a href="index.php?activate_all=true" class="btn btn-success float-end mx-2">Activate All</a>
                        <a href="add_trip.php" class="btn btn-primary float-end"> Add Trip </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-border table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Participants</th>
                                <th>Status</th>
                                <th colspan="2">Change Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = 'SELECT * FROM trips';
                            $select_all_trips = $pdo->prepare($query);
                            $select_all_trips->execute();

                            $trips = $select_all_trips->fetchAll();        
                        
                            foreach($trips as $row){
                                $trip_id=$row["id"];
                                $trip_image=$row["trip_image"];
                                $trip_title=$row["trip_title"];
                                $trip_price=$row["trip_price"];
                                $trip_status=$row["trip_status"];
                                $trip_participants=$row["trip_participants"];

                                echo "<tr>";
                                echo "<td>{$trip_title}</td>";
                                echo "<td>{$trip_price}</td>";
                                echo "<td><img width= '100' class='img-responsive' src= '../pictures/{$trip_image}' alt='There is no photo'></td>";
                                echo "<td>{$trip_participants}</td>";
                                echo "<td>{$trip_status}</td>";
                                echo "<td><a href='index.php?active_trip={$trip_id}'><button class='btn btn-primary'>Active</button></a></td>";
                                echo "<td><a href='index.php?unactive_trip={$trip_id}'><button class='btn btn-primary'>Unactive</button></a></td>";
                                echo "<td><a href='edit_trip.php?edit_trip_id={$trip_id}'><button class='btn btn-primary'>Edit</button></a></td>";
                                echo "<td><a href='index.php?delete_trip_id={$trip_id}'><button class='btn btn-danger'>Delete</button></a></td>";
                                echo "</tr>";
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    


if (isset($_GET['active_trip'])) {

    $the_trip_id = $_GET['active_trip'];
    $query = "UPDATE trips SET trip_status='Active' WHERE id = ? ";
    $active_query = $pdo->prepare( $query);
    $active_query->execute([$the_trip_id]);
    header("Location: index.php");
}
if (isset($_GET['unactive_trip'])) {

    $the_trip_id = $_GET['unactive_trip'];
    $query = "UPDATE trips SET trip_status='Unactive' WHERE id = ? ";
    $unactive_query = $pdo->prepare( $query);
    $unactive_query->execute([$the_trip_id]);
    header("Location: index.php");
}




if (isset($_GET['activate_all'])) {
    $query = "UPDATE trips SET trip_status='Active'";
    $activate_all_query = $pdo->prepare( $query);
    $activate_all_query->execute();
    header("Location: index.php");
}
if (isset($_GET['unactivate_all'])) {
    $query = "UPDATE trips SET trip_status='Unactive'";
    $unactivate_all_query = $pdo->prepare( $query);
    $unactivate_all_query->execute();
    header("Location: index.php");
}





if (isset($_GET['delete_trip_id'])) {

    $the_trip_id = $_GET['delete_trip_id'];
    $query = "DELETE FROM trips WHERE id = ? ";
    $delete_query = $pdo->prepare( $query);
    $delete_query->execute([$the_trip_id]);



    // delete all bookings associated with the trips
    $query = "DELETE FROM book_trip WHERE trip_id = ?";
    $delete_booking = $pdo->prepare( $query);
    $delete_booking->execute([$the_trip_id]);
    header("Location: index.php");
}

?>