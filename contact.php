<?php require "includes/head.php";

if (isset($_SESSION['username'])) {
    $email = $_SESSION['email'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $name = $firstname . ' ' . $lastname;
}

if (isset($_POST['submit'])) {
    $validation = [];


    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $body = isset($_POST['body']) ? trim($_POST['body']) : '';

    if (empty($name)) {
        $validation['name'] = 'Name field is required.';
    }

    if (empty($subject)) {
        $validation['subject'] = 'Subject field is required.';
    }
    if (empty($body)) {
        $validation['body'] = 'Message field is required.';
    }
    if (empty($email)) {
        $validation['email'] = 'Email address field is required.';
    } else {
        $valid = preg_match('/[0-z]+[@][0-z]+[.][A-z]+/', $_POST['email']) === 1;
        if (!$valid) {
            $validation['email'] = 'Email address must have a valid email format.';
        }
    }

    if (empty($validation)) {
        $to = "190ibrahimahmed@gmail.com";
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = '<html><body>';
        $message .= '<h1>' . $subject . '</h1>';
        $message .= '<p>Name: ' . $name . '</p>';
        $message .= '<p>Email: ' . $email . '</p>';
        $message .= '<p>' . $body . '</p>';
        $message .= '</body></html>';
        if (mail($to, $subject, $message, $headers)) {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo " <div class='alert alert-primary' role='alert'>Email Sent Successfully</div>";
        } else {
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo " <div class='alert alert-danger' role='alert'>Error sending email, please try again later.</div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Contact Us</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.14.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Styles/main.css">

</head>

<body>


    <main class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center section-title">
                    <br>
                    <br>
                    <h2>Get in Touch</h2>
                    <p>We're always here to help you with anything you need.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <form class="contact-form" action="" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= isset($name) ? $name : '' ?>" />
                            <?php
                            if (isset($validation) && isset($validation['name'])) { ?>
                                <span><?= $validation['name'] ?></span>
                            <?php   } ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?= isset($email) ? $email : '' ?>" />
                            <?php
                            if (isset($validation) && isset($validation['email'])) { ?>
                                <span><?= $validation['email'] ?></span>
                            <?php   } ?>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?= isset($subject) ? $subject : '' ?>" />
                            <?php
                            if (isset($validation) && isset($validation['subject'])) { ?>
                                <span><?= $validation['subject'] ?></span>
                            <?php   } ?>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="10" name="body" value="<?= isset($body) ? $body : '' ?>" /></textarea>
                            <?php
                            if (isset($validation) && isset($validation['body'])) { ?>
                                <span><?= $validation['body'] ?></span>
                            <?php   } ?>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="submit" class="btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>


<?php require "includes/footer.php"; ?>