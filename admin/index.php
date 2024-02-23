<?php
include "admin_header.php";
?>


<body>
    <?php include "admin_nav.php"; ?>



    <div id="user_table" class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <!-- <!-- <?php //if(isset($_SESSION['message'])) : ?> -->
                <!-- <h5 class="alert alert-success"><?php //$_SESSION['message']; ?></h5> -->
                <?php 
                    // unset($_SESSION['message']);
                    //endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Users
                            <a href="add_user.php" class="btn btn-primary float-end"> Add User </a>
                        </h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-border table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Date OF Birth</th>
                                    <th>Sex</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $query = 'SELECT * FROM users';
                            $statement = $pdo->prepare($query);
                            $statement->execute();

                            $result = $statement->fetchAll();        
                        
                            foreach($result as $row){
                                $user_id=$row["id"];
                                $username=$row["username"];
                                $firstname=$row["firstname"];
                                $lastname=$row["lastname"];
                                $email=$row["email"];
                                $birthday=$row["birthday"];
                                $sex=$row["sex"];
                                $phonenumber=$row["phonenumber"];
                                $role=$row["role"];

                                echo "<tr>";
                                echo "<td>{$username}</td>";
                                echo "<td>{$firstname}</td>";
                                echo "<td>{$lastname}</td>";
                                echo "<td>{$email}</td>";
                                echo "<td>{$birthday}</td>";
                                echo "<td>{$sex}</td>";
                                echo "<td>{$phonenumber}</td>";
                                echo "<td>{$role}</td>";
                                echo "<td>";
                                echo " <a href='edit_user.php?edit_id={$user_id}'><button class='btn btn-primary'>Edit</button></a> ";
                                echo "</td>";

                                echo "<td>";
                                echo " <a href='index.php?delete_id={$user_id}'><button class='btn btn-danger'>Delete</button></a> ";
                                echo "</td>";
                                echo "</tr>";
                            }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>

    <?php include "trips.php"; ?>
    <br>
    <br>
    <br>
    <?php include "bookings.php"; ?>


    <?php
include "admin_footer.php";
if (isset($_GET['delete_id'])) {
    $the_user_id = $_GET['delete_id'];
    $query = "DELETE FROM users WHERE id = ? ";
    $delete_query = $pdo->prepare( $query);
    $delete_query->execute([$the_user_id]);
    header("Location: index.php");
}



?>