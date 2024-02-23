<?php require "includes/head.php"; ?>
<?php require "includes/dbcon.php"; ?>

<?php
if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $validation = [];
        // First name validation
        if (!isset($_POST['firstname']) || $_POST['firstname'] === '') {
            $validation['firstname'] = 'First name field is required.';
        } else {
            $firstname = $_POST['firstname'];
        }

        // Last name validation
        if (!isset($_POST['lastname']) || $_POST['lastname'] === '') {
            $validation['lastname'] = 'Last name field is required.';
        } else {
            $lastname = $_POST['lastname'];
        }

        // Password validation
        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $validation['password'] = 'Password field is required.';
        } else if (!isset($_POST['password_confirm']) || $_POST['password'] !== $_POST['password_confirm']) {
            $validation['password_confirm'] = 'Password and password confirmation must match.';
            $validation['password'] = 'Password and password confirmation must match.';
        } else if (strlen($_POST['password']) < 10) {
            $validation['password'] = 'Password must have a length of 10 at least.';
        } else {
            $password = $_POST['password'];
            $confirm = $_POST['password_confirm'];
        }

        // Validate date of birth
        if (!isset($_POST['birthday']) || $_POST['birthday'] === '') {
            $validation['birthday'] = 'Date of birth field is required.';
        } else {
            $epoch = strtotime($_POST['birthday']);
            if (!$epoch) {
                $validation['birthday'] = 'Date of birth must be a valid date.';
            } else if ($epoch > time() || $epoch < strtotime('-150 years', time())) {
                $validation['birthday'] = 'Date of birth must be a valid date.';
            } else {
                $birthday = $_POST['birthday'];
            }
        }

        // Username validation
        if (!isset($_POST['username']) || $_POST['username'] === '') {
            $validation['username'] = 'Username field is required.';
        } else {
            $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $query->execute([$_POST['username']]);
            $usernames = $query->fetchAll();

            if (is_array($usernames) && count($usernames) > 0) {
                $validation['username'] = 'This username is already registered.';
            } else {
                $username = $_POST['username'];
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
                $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                $query->execute([$_POST['username']]);
                $emails = $query->fetchAll();

                if (is_array($emails) && count($emails) > 0) {
                    $validation['email'] = 'This email is already registered.';
                } else {
                    $email = $_POST['email'];
                }
            }
        }

        // Sex validation
        if (!isset($_POST['sex']) || $_POST['sex'] === '') {
            $validation['sex'] = 'Sex field is required.';
        } else {
            switch ($_POST['sex']) {
                case 'F':
                    $sexDbval = 0;
                    break;
                case 'M':
                    $sexDbval = 1;
                    break;
                case 'U':
                    $sexDbval = null;
                    break;
                default:
                    $validation['sex'] = 'Sex field must contain one of the options.';
                    break;
            }
            if (isset($sexDbval)) {
                $sex = $_POST['sex'];
            }
        }

        // License validation
        if (!isset($_POST['license']) || $_POST['license'] !== '1') {
            $validation['license'] = 'License agreement must be accepted.';
        } else {
            $license = $_POST['license'];
        }

        // Phone number validation
        if (!isset($_POST['phonenumber']) || $_POST['phonenumber'] == '') {
            $validation['phonenumber'] = 'Phone number must be filled in';
        } else {
            $phonenumber = $_POST['phonenumber'];
        }


        if (count($validation) === 0) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = $pdo->prepare('INSERT INTO users(username, email, password_hash, firstname, lastname, birthday, sex, license_accepted, verified) VALUES(?, ?, ?, ?, ?, ?, ?, 1, 1, ?)');
            $query->execute([$username, $email, $hash, $firstname, $lastname, $birthday, $sex, $phonenumber]);

            echo "<h6> New user successfully registered</h6>";
        }
    } else {
        echo "something went wrong";
    }
}

?>



<?php require "includes/footer.php"; ?>