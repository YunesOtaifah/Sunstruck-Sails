<?php include_once 'includes/head.php' ?>
<?php




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['SignIn'])) {
        $validation = [];
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        //todo: add email validation
        if (empty($password)) {
            $validation['password'] = 'Password field is required.';
        } else {
            $password = $_POST['password'];
        }

        if (empty($username)) {
            $validation['username'] = 'Username field is required.';
        } else {
            $username = $_POST['username'];
        }

        if (empty($validation)) {
            $query = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
            $query->execute([$username, $username]);
            $user = $query->fetchAll();
            if (!is_array(($user)) || count($user) === 0) {
                $validation['username'] = 'Username or password is incorrect.';
                $validation['password'] = 'Username or password is incorrect.';
            } else {

                foreach ($user as $row) {
                    $db_user_id = $row['id'];
                    $db_username = $row['username'];
                    $db_user_email = $row['email'];
                    $db_user_password = $row['password_hash'];
                    $db_user_firstname = $row['firstname'];
                    $db_user_lastname  = $row['lastname'];
                    $db_user_birthday = $row['birthday'];
                    $db_user_phonenumber = $row['phonenumber'];
                    $db_user_sex = $row['sex'];
                    $db_user_role = $row['role'];
                }
                if (($username === $db_username || $username === $db_user_email) && password_verify($password, $db_user_password)) {

                    $_SESSION['user_id'] = $db_user_id;
                    $_SESSION['username'] = $db_username;
                    $_SESSION['firstname'] = $db_user_firstname;
                    $_SESSION['lastname'] = $db_user_lastname;
                    $_SESSION['role'] = $db_user_role;
                    $_SESSION['sex'] = $db_user_sex;
                    $_SESSION['phonenumber'] = $db_user_phonenumber;
                    $_SESSION['birthday'] = $db_user_birthday;
                    $_SESSION['id'] = $db_user_id;
                    $_SESSION['email'] = $db_user_email;

                    if ($db_user_role === 'admin') {
                        header("Location: admin/index.php");
                    } elseif (isset($_GET['trip_id'])) {
                        header("Location: booktrip.php?trip_id=" . $_GET['trip_id']);
                    } else {
                        header("Location: index.php");
                    }
                } else {
                    // Login failed, bad password
                    $validation['username'] = 'Username or password is incorrect.';
                    $validation['password'] = 'Username or password is incorrect.';
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<?php
if (isset($_GET['trip_id'])) {
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo " <div class='alert alert-primary' role='alert'>You have to login first</div>";
}
?>

<body class="form-signin w-50 m-auto">


    <form method="POST" action="login.php">

        <h1 class="h3 mt-5 fw-normal text-center">Please log in</h1>
        <div class="form-floating">
            <input name="username" type="text" class="form-control" value="<?= isset($username) ? $username : '' ?>" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address or username</label>
            <?php
            if (isset($validation) && isset($validation['username'])) {
            ?>
                <span><?= $validation['username'] ?></span>
            <?php
            }
            ?>

        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control" value="<?= isset($password) ? $password : '' ?>" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            <?php
            if (isset($validation) && isset($validation['password'])) {
            ?>
                <span><?= $validation['password'] ?></span>
            <?php
            }
            ?>
        </div>


        <button class="w-100 btn btn-lg btn-primary" type="submit" name="SignIn">Sign in</button>
        <h6 class="mt-3">Don't have an account <a href="signup.php">Create your account</a></h6>
    </form>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


    <?php include_once 'includes/footer.php' ?>
</body>

</html>