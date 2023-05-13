<?php 

// USER SIGNIN
require_once ('../db_connection/conn.php');
if (user_is_logged_in()) {
    redirect(PROOT . 'account/index');
}
include ('../inc/header.inc.php');

$email = ((isset($_POST['authEmail']))? sanitize($_POST['authEmail']) : '');
$email = trim($email);
$password = ((isset($_POST['authPassword']))? sanitize($_POST['authPassword']) : '');
$password = trim($password);
$hashed = password_hash($password, PASSWORD_BCRYPT);
$errors = '';

if (isset($_POST['submit_login'])) {
    if (empty($email) || empty($password)) {
        $errors = '<div class="alert alert-light text-danger" role="alert">You must provide email and password</div>';
    }

    $query = "
        SELECT * FROM vonna_user 
        WHERE user_email = :user_email 
        LIMIT 1
    ";
    $statement = $conn->prepare($query);
    $statement->execute(
        array(
            ':user_email' => $email
        )
    );
    if ($statement->rowCount() < 1) {
        $errors = '<div class="alert alert-light text-danger" role="alert">That email does\'nt exist in our database.</div>';
    } else {
        foreach ($statement->fetchAll() as $row) {
            if ($row['user_trash'] == 0) {
                if ($row['user_verified'] != 1) {
                    redirect(PROOT . 'auth/resend-vericode');
                } else {
                    if (!password_verify($password, $row['user_password'])) {
                        $errors = '<div class="alert alert-light text-danger" role="alert">User cannot be found.</div>';
                    } else {
                        if (!empty($errors)) {
                            $errors;
                        } else {
                            $user_id = $row['user_id'];
                            userLogin($user_id);
                        }
                    }
                }
            } else {
                $errors = '<div class="alert alert-light text-danger" role="alert">User account Deactivated.</div>';
            }
        }
    }

}


?>
    <?= $flash; ?>
    <main class="">
        <div class="container-lg d-flex flex-column">
            <div class="row align-items-center justify-content-center min-vh-100 py-10 py-md-12 mt-n1">
                <div class="col-12 col-md-7 col-lg-5 text-center">
                    <h1 class="display-3 mb-4">
                        Sign In
                    </h1>
                    <p class="text-muted">
                        Don’t have an account? <a href="<?= PROOT; ?>auth/signup">Sign up</a>
                    </p>
                    <?= $errors; ?>
                    <form class="mb-6" method="POST">
                        <div class="form-group">
                            <label class="visually-hidden" for="authEmail">
                                Your email
                            </label>
                            <input class="form-control" id="authEmail" name="authEmail" type="email" placeholder="Your email" autocomplete="nope" autofocus>
                        </div>
                        <div class="form-group">
                            <div class="input-group inpit-group-merge">
                                <input class="form-control" id="authPassword" name="authPassword" placeholder="Your password" type="password" aria-label="Your password" aria-describedby="authPasswordCaption">
                                <a class="input-group-text text-decoration-none text-gray-500" id="authPasswordCaption" data-toggle="password" href="#authPassword">
                                    <i class="fe fe-eye"></i>
                                </a>
                            </div>
                        </div>
                        <button class="btn w-100 btn-warning" name="submit_login" id="submit_login">
                            Sign in
                        </button>
                    </form>
                    <a class="fs-sm" href="<?= PROOT; ?>auth/forgot-password">
                        Forgot your password?
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script src="<?= PROOT; ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
    <script src="<?= PROOT; ?>assets/js/vendor.bundle.js"></script>
    <script src="<?= PROOT; ?>assets/js/theme.bundle.js"></script>
    
    <script>
        // Fade out messages
        $("#temporary").fadeOut(5000);
    </script>
</body>
</html>
